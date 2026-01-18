import { useMemo, useEffect, useState } from "react";
import LoadingDots from "../../components/common/LoadingDots";
import AppHead from "../../components/common/AppHead";
import {
  useReactTable,
  getCoreRowModel,
  flexRender,
} from "@tanstack/react-table";
import TablePagination from "../../components/TablePagination";
import { Pencil, Trash2 } from "lucide-react";
import ServerNasService from "../../services/ServerNasService";

export default function ServerNasList() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [totalCount, setTotalCount] = useState(0);

  const [pagination, setPagination] = useState({
    pageIndex: 0,
    pageSize: 10,
  });

  const [searchTerm, setSearchTerm] = useState(""); // input live
  const [debouncedSearch, setDebouncedSearch] = useState(""); // search setelah delay

  const columns = useMemo(
    () => [
      { accessorKey: "name", header: "Name" },
      { accessorKey: "ip_address", header: "IP / Host" },
      { accessorKey: "secret", header: "Secret" },
      {
        accessorKey: "status",
        header: "Status",
        cell: ({ getValue }) => {
          const status = getValue();
          return (
            <span
              className={`px-2 py-1 text-xs font-medium rounded-full ${
                status === "active"
                  ? "bg-green-100 text-green-700"
                  : "bg-red-100 text-red-700"
              }`}
            >
              {status.charAt(0).toUpperCase() + status.slice(1)}
            </span>
          );
        },
      },
      {
        id: "actions",
        header: () => <div className="text-right">Action</div>,
        cell: () => (
          <div className="flex gap-2 justify-end">
            <button className="p-1 text-blue-500 hover:bg-blue-50 rounded">
              <Pencil size={16} />
            </button>
            <button className="p-1 text-red-500 hover:bg-red-50 rounded">
              <Trash2 size={16} />
            </button>
          </div>
        ),
      },
    ],
    [],
  );

  const table = useReactTable({
    data,
    columns,
    pageCount: Math.ceil(totalCount / pagination.pageSize),
    state: { pagination },
    onPaginationChange: setPagination,
    manualPagination: true,
    getCoreRowModel: getCoreRowModel(),
  });

  // 🔹 Debounce search
  useEffect(() => {
    const handler = setTimeout(() => {
      setDebouncedSearch(searchTerm);
      setPagination((prev) => ({ ...prev, pageIndex: 0 })); // reset pageIndex
    }, 500); // tunggu 500ms user selesai mengetik

    return () => clearTimeout(handler);
  }, [searchTerm]);

  // 🔹 Fetch data dari server saat pageIndex/pageSize/debouncedSearch berubah
  useEffect(() => {
    let isMounted = true;
    setLoading(true);

    ServerNasService.getAll({
      page: pagination.pageIndex + 1,
      limit: pagination.pageSize,
      search: debouncedSearch, // gunakan debounced search
    })
      .then((res) => {
        if (isMounted) {
          setData(res.data || []);
          setTotalCount(res.total || 0);
          setLoading(false);
        }
      })
      .catch((err) => {
        console.error("Error fetching NAS data:", err);
        if (isMounted) setLoading(false);
      });

    return () => {
      isMounted = false;
    };
  }, [pagination.pageIndex, pagination.pageSize, debouncedSearch]);

  if (loading) return <LoadingDots />;

  return (
    <div className="p-6 space-y-4">
      <AppHead title="Server NAS" />
      <div className="flex items-center justify-between">
        <h1 className="text-xl font-bold text-slate-800">Server NAS</h1>
        <button className="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium">
          + Add NAS
        </button>
      </div>

      {/* 🔹 Input pencarian dengan lebar terbatas */}
      <div className="mb-4">
        <input
          type="text"
          placeholder="Search by Name, IP, or Secret..."
          className="border rounded px-3 py-2 w-64 text-sm" // lebar input maksimal 16rem (w-64)
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
        />
      </div>

      <div className="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left">
            <thead className="bg-slate-50 border-b border-slate-200 text-slate-600">
              {table.getHeaderGroups().map((hg) => (
                <tr key={hg.id}>
                  {hg.headers.map((header) => (
                    <th key={header.id} className="px-4 py-3 font-semibold">
                      {flexRender(
                        header.column.columnDef.header,
                        header.getContext(),
                      )}
                    </th>
                  ))}
                </tr>
              ))}
            </thead>

            <tbody className="divide-y divide-slate-100">
              {table.getRowModel().rows.length ? (
                table.getRowModel().rows.map((row) => (
                  <tr key={row.id} className="hover:bg-slate-50">
                    {row.getVisibleCells().map((cell) => (
                      <td key={cell.id} className="px-4 py-3 text-slate-700">
                        {flexRender(
                          cell.column.columnDef.cell,
                          cell.getContext(),
                        )}
                      </td>
                    ))}
                  </tr>
                ))
              ) : (
                <tr>
                  <td
                    colSpan={columns.length}
                    className="px-4 py-10 text-center text-slate-400"
                  >
                    No data found.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        <TablePagination table={table} totalCount={totalCount} />
      </div>
    </div>
  );
}

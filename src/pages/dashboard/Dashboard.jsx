export default function Dashboard() {
    return (
        <div>
            <h1 className="text-2xl font-semibold mb-4">
                Dashboard
            </h1>

            <div className="grid grid-cols-3 gap-4">
                <div className="bg-white p-4 rounded shadow">
                    Total Customers
                </div>
                <div className="bg-white p-4 rounded shadow">
                    Active Sessions
                </div>
                <div className="bg-white p-4 rounded shadow">
                    Revenue
                </div>
            </div>
        </div>
    )
}

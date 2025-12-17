function Todo({
    todo,
    todos,
    setTodo,
    addTodo,
    toggleTodo,
    deleteTodo,
}) {
    return (
        <>
            <h1>Todo List</h1>

            <input
                type="text"
                value={todo}
                placeholder="Tambah todo..."
                onChange={(e) => setTodo(e.target.value)}
            />
            <button onClick={addTodo}>Tambah</button>

            <ul>
                {todos.map((item) => (
                    <li key={item.id}>
                        <span
                            onClick={() => toggleTodo(item.id)}
                            style={{
                                textDecoration: item.completed ? "line-through" : "none",
                                cursor: "pointer",
                            }}
                        >
                            {item.text}
                        </span>
                        <button onClick={() => deleteTodo(item.id)}>❌</button>
                    </li>
                ))}
            </ul>
        </>
    );
}

export default Todo;

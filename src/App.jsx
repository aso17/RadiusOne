import AppRoutes from './routes/Index'

export default function App() {
  return <AppRoutes />
}





// import { useState } from 'react'
// import Todo from './components/Todo'
// import './App.css'

// function App() {

//   const [todo, setTodo] = useState("");
//   const [todos, setTodos] = useState([]);

//   const addTodo = () => {
//     if (todo.trim() === "") return;

//     setTodos([
//       ...todos,
//       { id: Date.now(), text: todo, completed: false },
//     ]);
//     setTodo("");
//   };

//   const toggleTodo = (id) => {
//     setTodos(
//       todos.map((item) =>
//         item.id === id
//           ? { ...item, completed: !item.completed }
//           : item
//       )
//     );
//   };

//   const deleteTodo = (id) => {
//     setTodos(todos.filter((item) => item.id !== id));
//   };

//   return (
//     <Todo
//       todo={todo}
//       todos={todos}
//       setTodo={setTodo}
//       addTodo={addTodo}
//       toggleTodo={toggleTodo}
//       deleteTodo={deleteTodo}
//     />
//   );
// }

// export default App

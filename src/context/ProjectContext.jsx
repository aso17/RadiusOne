import { createContext, useEffect, useState } from "react";
import api from "../services/api";

export const ProjectContext = createContext();

export function ProjectProvider({ children }) {

    const [project, setProject] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        api.get("/project-info")
            .then(res => setProject(res.data))
            .finally(() => setLoading(false));
    }, []);

    return (
        <ProjectContext.Provider value={{ project, loading }}>
            {children}
        </ProjectContext.Provider>
    );
}

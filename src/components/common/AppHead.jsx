import { useContext, useEffect } from "react";
import { ProjectContext } from "../../context/ProjectContext";

export default function AppHead({ title }) {
  const { project } = useContext(ProjectContext);

  useEffect(() => {
    // 1️⃣ Ambil dari localStorage dulu
    let projectName = localStorage.getItem("project_name");
    let projectLogo = localStorage.getItem("project_logo");

    // 2️⃣ Kalau localStorage kosong → pakai context
    if (!projectName && project?.name) {
      projectName = project.name;
      localStorage.setItem("project_name", project.name);
    }

    if (!projectLogo && project?.logo_url) {
      projectLogo = project.logo_url;
      localStorage.setItem("project_logo", project.logo_url);
    }

    // 3️⃣ Default fallback
    projectName = projectName || "Application";

    // 4️⃣ Set title
    document.title = title ? `${title} | ${projectName}` : projectName;

    // 5️⃣ Set favicon
    if (projectLogo) {
      let link = document.querySelector("link[rel='icon']");
      if (!link) {
        link = document.createElement("link");
        link.rel = "icon";
        document.head.appendChild(link);
      }
      link.href = projectLogo;
    }
  }, [project, title]);

  return null;
}

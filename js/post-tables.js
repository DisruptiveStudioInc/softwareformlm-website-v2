document.addEventListener("DOMContentLoaded", () => {
  // Seleccionamos todas las tablas del documento
  const tables = document.querySelectorAll("table");

  tables.forEach((table) => {
    // Obtenemos los textos de los encabezados (th) de la tabla actual
    const headers = Array.from(table.querySelectorAll("th")).map((th) =>
      th.textContent.trim()
    );

    // Si no hay encabezados, no tiene sentido continuar con esta tabla
    if (headers.length === 0) return;

    // Iteramos sobre cada fila del cuerpo de la tabla
    const rows = table.querySelectorAll("tr");

    rows.forEach((row, key) => {
      const cells = row.querySelectorAll("td");

      if (key === rows.length - 1) {
        const hasStrongElement = row.querySelector("strong") !== null;
        if (hasStrongElement) {
          row.classList.add("row-as-foot");
          return; // Skip this row
        }
      }

      cells.forEach((cell, index) => {
        // Verificamos que exista un encabezado correspondiente al índice de la celda
        if (headers[index]) {
          cell.setAttribute("data-label", headers[index]);
        }
      });
    });
  });
});

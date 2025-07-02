window.onload = async function () {
  const res = await fetch("ranking.php");
  const data = await res.json();
  const tbody = document.getElementById("rankingBody");

  if (data.length === 0) {
    tbody.innerHTML = "<tr><td colspan='4'>ランキングがまだありません</td></tr>";
    return;
  }

  data.forEach((entry, index) => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${entry.username}</td>
      <td>${entry.score}</td>
      <td>${entry.play_date}</td>
    `;
    tbody.appendChild(row);
  });
};

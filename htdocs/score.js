document.addEventListener('DOMContentLoaded', () => {
  const currentUser = localStorage.getItem('currentUser');
  const list = document.getElementById("scoreList");
  list.innerHTML = "";

  const scores = JSON.parse(localStorage.getItem(`scores_${currentUser}`)) || [];
  scores.forEach((entry, i) => {
    const item = document.createElement("li");
    item.textContent = `${i + 1}位: ターン数 ${entry.score}`;
    if (entry.reason === "cpuout") {
      item.classList.add("cpuout");
      item.textContent += "（CPU切れ）";
    }
    list.appendChild(item);
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const currentUser = localStorage.getItem('currentUser') || 'guest';
  document.getElementById('usernameLabel').textContent = `ユーザー: ${currentUser}`;
  const list = document.getElementById('scoreList');
  const scores = JSON.parse(localStorage.getItem(`scores_${currentUser}`)) || [];

  scores.forEach((score, index) => {
    const item = document.createElement('li');
    item.textContent = `${index + 1}位: ターン数 ${score}`;
    list.appendChild(item);
  });
});

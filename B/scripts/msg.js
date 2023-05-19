
  const popup = document.getElementById('popup');
  const closeBtn = document.getElementById('closeBtn');

  closeBtn.addEventListener('click', () => {
    popup.style.display = 'none';
  });

  setTimeout(() => {
    popup.style.display = 'none';
  }, 15000);

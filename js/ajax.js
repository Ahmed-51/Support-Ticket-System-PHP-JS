const form = document.getElementById('ticketForm');
const responseDiv = document.getElementById('response');

form.addEventListener('submit', e => {
  e.preventDefault();
  if (!validateForm()) return;

  fetch('submit_ticket.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams(new FormData(form))
  })
    .then(res => res.text())
    .then(text => {
      responseDiv.innerText = text;
      responseDiv.className = 'mb-4 text-center font-semibold text-green-600';
      form.reset();
    })
    .catch(() => {
      responseDiv.innerText = 'Submission Error';
      responseDiv.className = 'mb-4 text-center font-semibold text-red-600';
    });
    form.reset();
});


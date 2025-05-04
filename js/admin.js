// 1) Select All Checkbox
const selectAllBtn = document.getElementById('select-all-btn');
if (selectAllBtn) {
  let allSelected = false;
  selectAllBtn.addEventListener('click', () => {
    allSelected = !allSelected;
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = allSelected);
    selectAllBtn.innerText = allSelected ? 'Deselect All' : 'Select All';
  });
}



// 2) Details Modal
const detailModal   = document.getElementById('detailModal');
const modalContent  = document.getElementById('modalContent');
const modalCloseBtn = document.getElementById('modalClose');
document.querySelectorAll('.detail-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const row = btn.closest('tr');
    modalContent.innerHTML = `
      <p><strong>ID:</strong> ${row.dataset.id}</p>
      <p><strong>Name:</strong> ${row.dataset.name}</p>
      <p><strong>Email:</strong> ${row.dataset.email}</p>
      <p><strong>Created:</strong> ${row.dataset.created}</p>
      <p><strong>Message:</strong><br/>${row.dataset.message}</p>
    `;
    detailModal.classList.remove('hidden');
  });
});
if (modalCloseBtn) {
  modalCloseBtn.addEventListener('click', () => detailModal.classList.add('hidden'));
}

// 3) Toggle Status
document.querySelectorAll('.toggle-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const row         = btn.closest('tr');
    const id          = row.dataset.id;
    const statusSpan  = row.querySelector('span');
    const oldStatus   = statusSpan.innerText.trim();
    const newStatus   = oldStatus === 'open' ? 'closed' : 'open';

    fetch('toggle_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${encodeURIComponent(id)}&status=${encodeURIComponent(oldStatus)}`
    })
    .then(res => res.text())
    .then(() => {
      statusSpan.innerText   = newStatus;
      statusSpan.className   = newStatus === 'open'
        ? 'px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800'
        : 'px-2 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800';
    })
    .catch(err => {
      console.error('Toggle error:', err);
      alert('Failed to toggle ticket status.');
    });
  });
});

// 4) Delete Ticket
document.querySelectorAll('.delete-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const row = btn.closest('tr');
    const id  = row.dataset.id;
    if (!confirm(`Delete ticket #${id}? This cannot be undone.`)) return;

    fetch('delete_ticket.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${encodeURIComponent(id)}`
    })
    .then(res => res.text())
    .then(() => row.remove())
    .catch(err => {
      console.error('Delete error:', err);
      alert('Failed to delete ticket.');
    });
  });
});



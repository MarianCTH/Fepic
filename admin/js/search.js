const searchInput = document.getElementById('searchInput');
const tableRows = document.getElementsByClassName('searchable-row');
const pagination = document.querySelector('.dm-pagination');

searchInput.addEventListener('input', function () {
    const searchTerm = searchInput.value.toLowerCase();
    
    // Hide pagination when there is a search term
    if (searchTerm.trim() !== '') {
        pagination.style.display = 'none';
    } else {
        pagination.style.display = 'block';
    }

    for (let i = 0; i < tableRows.length; i++) {
        const row = tableRows[i];
        const name = row.querySelector('.userDatatable-inline-title h6').textContent.toLowerCase();
        const company = row.querySelector('.userDatatable-inline-title p').textContent.toLowerCase();
        const email = row.querySelector('.userDatatable-content a').textContent.toLowerCase();

        if (name.includes(searchTerm) || company.includes(searchTerm) || email.includes(searchTerm)) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    }
});

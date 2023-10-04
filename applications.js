$(document).ready(function () {
    const applicationsTable = $('#applicationsTable');
    const pagination = $('#pagination');

    function updatePagination(currentPage, totalPages) {
        pagination.html(`${currentPage} of ${totalPages}`);
    }

    function loadApplications(page) {
        $.ajax({
            url: `applications.php?page=${page}`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                applicationsTable.html(response.tableHTML);
                updatePagination(response.currentPage, response.totalPages);
            },
            error: function (error) {
                console.error('Error loading applications:', error);
            }
        });
    }

    // Initial load
    loadApplications(1);

    pagination.on('click', '#prevPageBtn', function () {
        const currentPage = parseInt(pagination.text().split(' ')[0]);
        if (currentPage > 1) {
            loadApplications(currentPage - 1);
        }
    });

    pagination.on('click', '#nextPageBtn', function () {
        const currentPage = parseInt(pagination.text().split(' ')[0]);
        const totalPages = parseInt(pagination.text().split(' ')[2]);
        if (currentPage < totalPages) {
            loadApplications(currentPage + 1);
        }
    });
});

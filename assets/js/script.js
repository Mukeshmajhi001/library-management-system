// Library Management System JavaScript

$(document).ready(function() {
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Confirm delete actions
    $('.delete-confirm').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        if (confirm('Are you sure you want to delete this item? This action cannot be undone!')) {
            window.location.href = href;
        }
    });
    
    // Search form submit on select change
    $('#status-filter').change(function() {
        $('#search-form').submit();
    });
    
    // Date picker enhancements
    $('#due_date').attr('min', new Date().toISOString().split('T')[0]);
    
    // Student ID validation
    $('#student_id').on('input', function() {
        var studentId = $(this).val();
        if (studentId.length < 3) {
            $(this).removeClass('is-valid').addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });
    
    // Book search autocomplete
    $('#book_search').on('keyup', function() {
        var query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: 'search-books.php',
                type: 'POST',
                data: {query: query},
                success: function(data) {
                    $('#book_results').html(data).show();
                }
            });
        } else {
            $('#book_results').hide();
        }
    });
    
    // Print report
    $('#print-report').click(function() {
        window.print();
    });
    
    // Export to CSV
    $('#export-csv').click(function() {
        var table = $('#data-table');
        var csv = [];
        
        // Get headers
        var headers = [];
        table.find('thead th').each(function() {
            headers.push($(this).text());
        });
        csv.push(headers.join(','));
        
        // Get data
        table.find('tbody tr').each(function() {
            var row = [];
            $(this).find('td').each(function() {
                row.push('"' + $(this).text().replace(/"/g, '""') + '"');
            });
            csv.push(row.join(','));
        });
        
        // Download CSV
        var csvContent = csv.join('\n');
        var blob = new Blob([csvContent], {type: 'text/csv'});
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'report.csv';
        a.click();
    });
    
    // Dark mode toggle
    $('#dark-mode-toggle').click(function() {
        $('body').toggleClass('dark-mode');
        localStorage.setItem('darkMode', $('body').hasClass('dark-mode'));
    });
    
    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'true') {
        $('body').addClass('dark-mode');
    }
    
    // Form validation
    $('form').on('submit', function(e) {
        var isValid = true;
        $(this).find('[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
    
    // Number input validation
    $('input[type="number"]').on('input', function() {
        var min = $(this).attr('min');
        var max = $(this).attr('max');
        var val = parseInt($(this).val());
        
        if (min && val < parseInt(min)) {
            $(this).val(min);
        }
        if (max && val > parseInt(max)) {
            $(this).val(max);
        }
    });
    
    // Show loading spinner on form submit
    $('form').on('submit', function() {
        if ($(this).valid()) {
            $('body').append('<div class="spinner-overlay"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        }
    });
    
    // Back to top button
    var backToTop = $('<button>', {
        id: 'back-to-top',
        class: 'btn btn-primary position-fixed bottom-0 end-0 m-4',
        html: '<i class="fas fa-arrow-up"></i>',
        css: {
            display: 'none',
            'z-index': '1000',
            'border-radius': '50%',
            'width': '40px',
            'height': '40px'
        },
        click: function() {
            $('html, body').animate({scrollTop: 0}, 500);
        }
    });
    
    $('body').append(backToTop);
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
});

// Additional utility functions

// Format currency
function formatCurrency(amount) {
    return '₹' + parseFloat(amount).toFixed(2);
}

// Format date
function formatDate(date) {
    var d = new Date(date);
    return d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
}

// Calculate days between two dates
function daysBetween(date1, date2) {
    var oneDay = 24 * 60 * 60 * 1000;
    var firstDate = new Date(date1);
    var secondDate = new Date(date2);
    return Math.round(Math.abs((firstDate - secondDate) / oneDay));
}

// Validate email
function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Validate phone number
function validatePhone(phone) {
    var re = /^[0-9]{10}$/;
    return re.test(phone);
}

// Show notification
function showNotification(message, type) {
    var notification = $('<div>', {
        class: 'alert alert-' + type + ' alert-dismissible fade show position-fixed top-0 end-0 m-3',
        role: 'alert',
        html: message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>',
        css: {
            'z-index': '9999',
            'min-width': '300px'
        }
    });
    
    $('body').append(notification);
    
    setTimeout(function() {
        notification.alert('close');
    }, 5000);
}
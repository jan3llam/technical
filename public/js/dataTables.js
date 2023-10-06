var tableList = function () {
    var table = document.getElementsByClassName('table_new');
    var datatable;
    var initUserTable = function () {
        datatable = $(table).DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            "info": false,
            'order': [],
            "pageLength": 10,
            "lengthChange": false,
            order: [
                [0, "desc"]
            ],
            "language": {
                sProcessing: "جارٍ التحميل...",
                sLengthMenu: "أظهر _MENU_ مدخلات",
                sZeroRecords: "لم يعثر على أية سجلات",
                sInfo: "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                sInfoEmpty: "يعرض 0 إلى 0 من أصل 0 سجل",
                sInfoFiltered: "(منتقاة من مجموع _MAX_ مُدخل)",
                sInfoPostFix: "",
                sSearch: "ابحث:",
                sUrl: "",
                oPaginate: {
                    sFirst: "الأول",
                    sPrevious: "السابق",
                    sNext: "التالي",
                    sLast: "الأخير",
                },
            },
        });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    return {
        init: function () {
            if (!table) {
                return;
            }

            initUserTable();
            handleSearchDatatable();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    tableList.init();
});

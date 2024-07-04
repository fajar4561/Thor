<?php require 'public/component/head.php';?>
<body id="body">
    <!-- leftbar-tab-menu -->
    

    <?php require 'public/component/body.php';?>

    <script src="<?=$link?>public/resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=$link?>public/resources/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?=$link?>public/resources/assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?=$link?>public/resources/assets/libs/mobius1-selectr/selectr.min.js"></script>
    <script src="<?=$link?>public/resources/assets/libs/huebee/huebee.pkgd.min.js"></script>
    <script src="<?=$link?>public/resources/assets/libs/vanillajs-datepicker/js/datepicker-full.min.js"></script>
    <script src="<?=$link?>public/resources/assets/js/moment.js"></script>
    <script src="<?=$link?>public/resources/assets/libs/imask/imask.min.js"></script>

    <script src="<?=$link?>public/resources/assets/js/pages/forms-advanced.js"></script>
    <!-- App js -->
    <script src="<?=$link?>public/resources/assets/js/app.js"></script>
    <script src="<?=$link?>public/resources/assets/js/pages/toast.init.js"></script>
    <script src="<?=$link?>public/resources/assets/libs/simple-datatables/umd/simple-datatables.js"></script>
    <script src="<?=$link?>public/resources/assets/js/pages/datatable.init.js"></script>

    <!-- DataTables JS -->
    <script src="<?=$link?>public/plugins/datatables/js/dataTables.js"></script>
    <script src="<?=$link?>public/plugins/datatables/js/dataTables.fixedColumns.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

</body>

</html>
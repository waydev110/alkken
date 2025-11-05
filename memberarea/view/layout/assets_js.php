

    <!-- Required jquery and libraries -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datepicker/bootstrap-datepicker.js"></script>

    <!-- cookie js -->
    <script src="assets/js/jquery.cookie.js"></script>

    <!-- Customized jquery file  -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/color-scheme.js"></script>


    <!-- Chart js script -->
    <script src="assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="assets/vendor/swiperjs-6.6.2/swiper-bundle.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/vendor/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/vendor/owlcarousel/owl.carousel.min.js"></script>
    
    <script type="text/javascript">
    
            
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
     $(function(){
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
      $(".datepicker").datepicker({
          format: 'dd/mm/yyyy',
          autoclose: true,
          todayHighlight: true,
      });
      $("#daftar_akun").change(function(){
            var id_member = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'controller/login/change_akun.php',
                data: {
                    id_member: id_member
                },
                success: function (result) {
                    const obj = JSON.parse(result);
                    if( obj.status == true){
                        location.reload();
                    } else {
                        alert('Tidak dapat beralih akun.');
                    }
                }
            });
      });
     });
     
     function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
    </script>

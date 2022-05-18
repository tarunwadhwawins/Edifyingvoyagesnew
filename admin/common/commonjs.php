<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="assets/form-validator/jquery.form-validator.js"></script>

  <!-- <script src="assets/js/ckeditor.js"></script> -->
  <script>
    $(document).ready(function() {
      $.validate({
         modules: 'security'
      });
      $("#menu").click(function() {
        $("body").toggleClass('show')
      });
    });

    //---//

    $(".sub-menu ul").toggleClass('hideUl');
    $(".sub-menu a").click(function () {

      $(this).parent(".sub-menu").children("ul").toggleClass('hideUl').slide("100");
      $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
    });
  </script>

<!--scripts-->
<script type="text/javascript" src="<?php echo $url; ?>assets/js/jquery-3.5.0.min.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>assets/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>assets/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>assets/js/jquery.easy-pie-chart.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>assets/js/scripts.js"></script>
<!---->
<script src="assets/form-validator/jquery.form-validator.js"></script>
    <script>
    	var base_url = '<?php echo $url; ?>';
        $(document).ready(function(){
            $.validate({
                modules: 'security'
            });
            $("#contactForm").submit(function(e){
            	e.preventDefault();
            	$.ajax({
	                url: base_url+"core/general?action=ConactFormSave",
	                type: "POST",
	                data: $(this).serialize(),
	                success: function (response) {
	                    var $messageDiv = $('#quotesmessage')
	                    $messageDiv.hide().html(response.Message);          
	                    if(response.Success == true) {
	                        $messageDiv.text('Thank You! Our Team Will Get Back To You Soon!!');
	                        document.getElementById("contactForm").reset();
	                        $messageDiv.addClass('alert alert-success').fadeIn(1500);
	                    } else {
	                        $messageDiv.text('Error');
	                        $messageDiv.addClass('alert alert-danger').fadeIn(1500);
	                    }
	                    setTimeout(function(){
	                        $messageDiv.fadeOut(1500);
	                    }, 3000);
	                }
	            });
            });
        });
    </script>
</body>

</html>
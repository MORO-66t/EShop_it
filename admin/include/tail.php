				<!--=*= FOOTER SECTION START =*=-->

				<footer class="sticky-footer" id="footer">

					All Rights Reserverd &copy; <?php echo date("Y"); ?> | Developed by 

					<a href="//aamroni.info/" target="_blank">

						<b> Mohammed Ragab </b>

					</a> 

				</footer>

				<!--=*= FOOTER SECTION END =*=-->

			</div>

		</section>



		<!--=*= JS FILES SOURCE START =*=-->

		<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

		<script src="assets/js/jquery-migrate-1.2.1.min.js"></script>

		<script src="assets/js/bootstrap.min.js"></script>

		<script src="assets/js/modernizr.min.js"></script>

		<script src="assets/js/jquery.nicescroll.js"></script>



		<script type="text/javascript" language="javascript" src="public/js/datatable/jquery.dataTables.js"></script>

		<script type="text/javascript" src="public/js/datatable/DT_bootstrap.js"></script>

		<script src="assets/js/datatable/dynamic_table_init.js"></script>

		<!--=*= JS FILES SOURCE END =*=-->





		<!--=*= UPLOADED FILE PREVIEWER SCRIPT START =*=-->

		<script type="text/javascript">

			function readURL(input) {

				if (input.files && input.files[0]) {

					var reader = new FileReader();

					var div_id  = $(input).attr('set-to');

					reader.onload = function (e) {

						$('#'+div_id).attr('src', e.target.result);

					}

					reader.readAsDataURL(input.files[0]);

				}

			}

			

			$(".default").change(function(){

				readURL(this);

			});

		</script>

		<!--=*= UPLOADED FILE PREVIEWER SCRIPT END =*=-->





		<!--=*= NUMBER COUNTER LIBRARIES START =*=-->

		<script src="assets/js/jquery.counterup.js"></script>

		<script src="assets/js/jquery.waypoints.min.js"></script>

		<script type="text/javascript">

			$(".counter").counterUp({delay: 1, time: 300});

		</script>

		<!--=*= NUMBER COUNTER LIBRARIES END =*=-->

		<!--=*= COMMON SCRITP FOR ALL PAGES =*=-->

		<script src="assets/js/scripts.js"></script>



		<!--=*= DISABLE IMAGE DRAG START =*=-->

		<script type="text/javascript">

			$("img").mousedown(function(){

				return false;

			});

		</script>

		<!--=*= DISABLE IMAGE DRAG END =*=-->



	</body>

</html>
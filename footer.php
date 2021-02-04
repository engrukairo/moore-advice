  <footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row text-center">
      <div class="col-12 col-md">
        <img class="mb-2" src="images/mooreadvice.png" alt="" height="24">
        <small class="d-block text-muted">&copy; <?php echo date("Y"); ?> Moore Advice Ltd</small>
      </div>
    </div>
  </footer>
</div>
<script src="https://moore.esperasoft.com/css/bootstrap-datepicker.js"></script>
<script src="https://moore.esperasoft.com/js/moore.js"></script>
<script>
  $(function () {
    $('#datepicker1').datepicker({
      autoclose: true
    });
    $('#datepicker2').datepicker({
      autoclose: true
    });
  });
</script><?php if(isset($extrajs)){echo $extrajs;}?>
</body>
</html>
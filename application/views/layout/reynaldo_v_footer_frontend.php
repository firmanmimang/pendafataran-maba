              
        </div><!-- /.container -->
      </div><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer bg-dark">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2014-<?= date('Y') ?> <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>


  </div><!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script type="text/javascript">
  window.setTimeout(function(){
    $('.alert').fadeTo(500,0).slideUp(500,function(){
      $(this).remove();
    });
  },5000);
</script>
<!-- <script type="text/javascript">
  window.setTimeout(function(){
    $('.text-danger').fadeTo(500,0).slideUp(500,function(){
      $(this).remove();
    });
  },10000);
</script>
 -->
<!-- bs-custom-file-input -->
<script src="<?= base_url('assets/adminlte/') ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>

  </body>
</html>


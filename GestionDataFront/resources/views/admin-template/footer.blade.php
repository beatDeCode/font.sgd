	      <footer class="footer">
	    
	    <div class="ms-auto">Seguros La Fe, C.A © 2022 <a href="https://coreui.io/docs/">Gestión Data</a></div>
	  </footer>
	</div>
    <script src="/jquery.min.js"></script>
    <script src="/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="/vendors/simplebar/js/simplebar.min.js"></script>
    <script src="/vendors/DataTables/datatables.min.js"></script>
    <script src="/vendors/sweetalerts/dist/sweetalert2.min.js"></script>
    
    @foreach($vScripts as $vScript)
    <script src="/{{$vScript}}"></script>
    @endforeach
    <script>
      function fnMarcarMenu(pMenu,pSubmenu){
          var vMenu=$('li[id="li-'+pMenu+'"]');
          vMenu.addClass('show');
          vMenu.attr('aria-expanded',true);
          var vSubmenu=$('a[id="sm-a-'+pSubmenu+'"]');
          vSubmenu.addClass('active');
      }
      fnMarcarMenu({{$vMenu}},{{$vSubmenu}});
    </script>

  </body>
</html>
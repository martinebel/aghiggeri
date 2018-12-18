  <!--   FOOTER START================== -->

    <footer class="footer">
    <div class="container">
        <div class="row">
        <div class="col-sm-4 col-xs-12 col-md-offset-4">
            <h4 class="title">Casa Central</h4>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i> Av. 25 de Mayo 1164<br>Resistencia, Chaco</p>
			 <p><i class="fa fa-phone" aria-hidden="true"></i> 0362 – 4433100 - 4451555</p>
			  <p><i class="fa fa-phone" aria-hidden="true"></i> 0362-155240760 (Whatsapp)</p>
			  <p><i class="fa fa-envelope" aria-hidden="true"></i> ventas@agustinghiggeri.com.ar</p>
			  </div>

			   <div class="col-sm-4 col-xs-12">

			  </div>
			  <div class="col-sm-12">
            <ul class="social-icon">
            <!--<a href="#" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>-->
            <a href="http://qr.afip.gob.ar/?qr=TluV2sJkUY_VXQn16XN5Tg,," target="_blank" title="DATA"> <img class=" hover_effect " src="http://www.afip.gob.ar/images/f960/DATAWEB.jpg" alt="DATA" width="60" height="82"> </a>
            <p>Los Precios No Incluyen el I.V.A</p>
            <p>Los Precios No Incluyen Percepciones de Ingresos Brutos que puedieran corresponder de acuerdo a vs. Jurisdicción</p>
			</ul>
            </div>



        </div>
        <hr>

        <div class="row text-center"> Desarrollado por Martin Ebel | ebel.martin@gmail.com</div>
        </div>


    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script>
     $('.dropdown a').on('click', function(e){

		   $('.submenu').each(function(i, obj) {

      $(obj).removeClass('in');
});

       });
  </script>
  <script type="text/javascript">
    ! function($, n, e) {
      var o = $();
      $.fn.dropdownHover = function(e) {
        return "ontouchstart" in document ? this : (o = o.add(this.parent()), this.each(function() {
          function t(e) {
            o.find(":focus").blur(), h.instantlyCloseOthers === !0 && o.removeClass("open"), n.clearTimeout(c), i.addClass("open"), r.trigger(a)
          }
          var r = $(this),
            i = r.parent(),
            d = {
              delay: 100,
              instantlyCloseOthers: !0
            },
            s = {
              delay: $(this).data("delay"),
              instantlyCloseOthers: $(this).data("close-others")
            },
            a = "show.bs.dropdown",
            u = "hide.bs.dropdown",
            h = $.extend(!0, {}, d, e, s),
            c;
          i.hover(function(n) {
            return i.hasClass("open") || r.is(n.target) ? void t(n) : !0
          }, function() {
            c = n.setTimeout(function() {
              i.removeClass("open"), r.trigger(u)
            }, h.delay)
          }), r.hover(function(n) {
            return i.hasClass("open") || i.is(n.target) ? void t(n) : !0
          }), i.find(".dropdown-submenu").each(function() {
            var e = $(this),
              o;
            e.hover(function() {
              n.clearTimeout(o), e.children(".dropdown-menu").show(), e.siblings().children(".dropdown-menu").hide()
            }, function() {
              var t = e.children(".dropdown-menu");
              o = n.setTimeout(function() {
                t.hide()
              }, h.delay)
            })
          })
        }))
      }, $(document).ready(function() {
        $('[data-hover="dropdown"]').dropdownHover()
      })
    }(jQuery, this);
  </script>

  <script>

  var uid="<?php echo $_SESSION['uid'];?>";
  var cid="<?php echo (isset($_SESSION['cid'])?$_SESSION['cid']:"");?>";
  function addCart(id)
  {
	  swal({
  title: "Comprar",
  text: "Por favor, indique la cantidad que desea comprar:",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  animation: "slide-from-top",
  cancelButtonText: "Cancelar",
  inputPlaceholder: "1"
},
function(inputValue){
  if (inputValue === false) return false;

  if (inputValue === "" || !$.isNumeric(inputValue) || inputValue === "0") {
    swal.showInputError("Debe indicar la cantidad que desea comprar!");
    return false
  }

 $.ajax({
        type: "POST",
        url: "cartClass.php?action=addCart&clave="+uid+"&id="+id+"&cant="+inputValue+"&cid="+cid,
        processData: false,
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
	 var obj = JSON.parse( datae );
	swal({title:"Agregado al Pedido!", text:"Se agregaron " + inputValue+" unidad(es) de "+obj[0].nombre+" a su pedido.", type:"success"},
	function(){
 location.reload();
});

    })
    .fail(function(jqXHR, textStatus, errorThrown){

    });
});



  }

  function emptyCart()
  {
 swal({
      title: "Vaciar Carrito",
      text: "Está seguro de querer eliminar todos los productos de su carrito?",
      type: "warning",
      showCancelButton: true,
      closeOnConfirm: false,
	  cancelButtonText: "Cancelar",
      confirmButtonText: "Si, eliminar todo",
      confirmButtonColor: "#ec6c62"
    }, function() {
      $.ajax({
        type: "POST",
        url: "cartClass.php?action=emptyCart&clave="+uid,
        processData: false,
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
	swal({title:"Vaciar Carrito", text:"Su carrito ha sido vaciado. Puede seguir comprando!", type:"success"},
	function(){

location.reload();
});

    })
    .fail(function(jqXHR, textStatus, errorThrown){

    });

    });
  }


  function removeCart(id)
  {
	   $.ajax({
        type: "POST",
        url: "cartClass.php?action=removeCart&clave="+uid+"&id="+id,
        processData: false,
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
	 var obj = JSON.parse( datae );
	swal({title:"Producto Eliminado!", text:"Se elimino el producto "+obj[0].nombre+" de su pedido.", type:"success"},
	function(){

location.reload();
});

    })
    .fail(function(jqXHR, textStatus, errorThrown){

    });
  }


  function removeTemp(id)
  {
     $.ajax({
        type: "POST",
        url: "cartClass.php?action=emptyCart&clave="+id,
        processData: false,
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
location.reload();
    })
    .fail(function(jqXHR, textStatus, errorThrown){

    });
  }

   function reloadTemp(id)
  {
     $.ajax({
        type: "POST",
        url: "cartClass.php?action=reloadCart&clave="+id+"&uid="+uid,
        processData: false,
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
window.location.href="cart.php";
    })
    .fail(function(jqXHR, textStatus, errorThrown){

    });
  }

  //autocomplete search
  (function($){
  $( "#keyword" ).autocomplete({
    source: "ajax_search.php",
      minLength: 2,
      select: function( event, ui ) {
		window.location.href="detalle.php?id="+ui.item.id;
      }
  });

   $( "#keyword" ).data( "ui-autocomplete" )._renderItem = function( ul, item ) {

    var $li = $('<li>'),
        $img = $('<img  onerror="this.src=\'default.jpeg\';">');


    $img.attr({
      src: item.icon,
	  width:"100px",
	  height:"50px"
    });

    $li.attr('data-value', item.label);
    $li.append('<a href="#">');
    $li.find('a').append($img).append(item.label);

    return $li.appendTo(ul);
  };


})(jQuery);


  </script>

   <script>

    $('#autofilter').on('change',function() {

$( "#modelofilter" ).empty();
       $.ajax({
        type: "GET",
        url: "ajax_search.php?action=autofilter&clave="+$("#autofilter").val(),
        processData: false,
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
	 var obj = JSON.parse( datae );

	for(var i=0;i<obj.length;i++)
	{
		$("#modelofilter").append('<option value="'+obj[i].modelo+'">'+obj[i].modelo+'</option>');
	}

    })
    .fail(function(jqXHR, textStatus, errorThrown){

    });
    });


  </script>

  <!-- Smartsupp Live Chat script -->

<script type="text/javascript">

var _smartsupp = _smartsupp || {};

_smartsupp.key = 'a2cad8d933188957680a7dbad4e964cbbe917b0f';

window.smartsupp||(function(d) {

  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];

  s=d.getElementsByTagName('script')[0];c=d.createElement('script');

  c.type='text/javascript';c.charset='utf-8';c.async=true;

  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);

})(document);

</script>
</body>

</html>

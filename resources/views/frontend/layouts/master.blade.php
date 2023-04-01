
<!DOCTYPE html>
<html lang="en">
<head>
@include('backend.layouts.header')
  <!-- Basic Page Needs
================================================== -->
  <meta charset="utf-8">
  <title>Constra - Construction Html5 Template</title>

  <!-- Mobile Specific Metas
================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

  <!-- Favicon
================================================== -->
  <link rel="icon" type="image/png" href="images/favicon.png">

  <!-- CSS
================================================== -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
  <!-- Animation -->
  
  <!-- Template styles-->
  <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/style.css">

</head>
<body>
  <div class="body-inner">

<!-- Header start -->
@include('frontend.layouts.topheader')

@include('frontend.layouts.topmenu')
<!--/ Header end -->
<!-- Content Body  -->

@yield('content')

<!-- Content Body  -->

  <!-- Javascript Files
  ================================================== -->

 <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
	});
</script>

@include('backend.layouts.footer')


<!-- For Handlebars JS -->

<!-- End Handlebar JS -->
  </div>
</body>

  </html>
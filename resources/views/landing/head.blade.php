<!DOCTYPE html>
<html lang="en">

<head>
  <!--====== Required meta tags ======-->
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!--====== Title ======-->
  <title>{{env('APP_NAME')}} | Landing</title>

  <!--====== Favicon Icon ======-->
  <link href="{{ asset('landing/login/img/logo.png') }}" rel="icon">

  <!--====== Bootstrap css ======-->
  <link rel="stylesheet" href="{{ asset('landing/assets/css/bootstrap.min.css')}}" />

  <!--====== Line Icons css ======-->
  <link rel="stylesheet" href="{{ asset('landing/assets/css/lineicons.css')}}" />

  <!--====== Tiny Slider css ======-->
  <link rel="stylesheet" href="{{ asset('landing/assets/css/tiny-slider.css')}}" />

  <!--====== gLightBox css ======-->
  <link rel="stylesheet" href="{{ asset('landing/assets/css/glightbox.min.css')}}" />

  <link rel="stylesheet" href="{{ asset('landing/style.css')}}" />
  <style>
    #hero-area .animated{
        animation: up-down 2s ease-in-out infinite alternate-reverse both;
    }
    @-webkit-keyframes up-down {
      0% {
        transform: translateY(10px);
      }
    
      100% {
        transform: translateY(-10px);
      }
    }

    @keyframes up-down {
      0% {
        transform: translateY(10px);
      }
    
      100% {
        transform: translateY(-10px);
      }
    }
  </style>
</head>

<body>

  <!--====== NAVBAR NINE PART START ======-->
    @yield('content')



  <a href="#" class="scroll-top btn-hover">
    <i class="lni lni-chevron-up"></i>
  </a>

  <!--====== js ======-->
  <script src="{{asset('landing/assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('landing/assets/js/glightbox.min.js')}}"></script>
  <script src="{{asset('landing/assets/js/main.js')}}"></script>
  <script src="{{asset('landing/assets/js/tiny-slider.js')}}"></script>
  <script src="{{asset('landing/assets/js/anime.js')}}"></script>
  <script>
    const button = document.getElementById("btn-masuk");

    const animateMove = (element, prop, pixels) =>
      anime({
        targets: element,
        [prop]: `${pixels}px`,
        easing: "easeOutCirc"
      });
    
    ["mouseover", "click"].forEach(function (el) {
      button.addEventListener(el, function (event) {
        const top = getRandomNumber(600);
        const left = getRandomNumber(800);
      
        animateMove(this, "left", left).play();
        animateMove(this, "top", top).play();
      });
    });
    
    const getRandomNumber = (num) => {
      return Math.floor(Math.random() * (num + 1));
    };
  </script>
</body>
</html>
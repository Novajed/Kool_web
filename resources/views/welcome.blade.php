<!DOCTYPE html>

<html lang="en">

<head>
    <title>Koolriculum</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
     <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>     
    
<body>
    
<div>
 <div>
  <nav>
    <ul>
         <li><a href="http://koolriculumclub.com/">Home</a></li>
         <li><a href="http://koolriculumclub.com/allaboutkoolriculum/">About KOOLriculum</a>
        </li>

@guest
<li><a href="/login">Login</a>
<ul class="sub-menu">
    <li><a href="/login">Individual/Student</a>
   
</li>
    <li><a href="/portal">Teacher</a>
</li>
</ul>
    
</li>
<li>
<a href="http://koolriculumclub.com/subjects/">Register</a>
<ul>
<li>
    <a href="/register">Individual/Student Registration</a>   
</li>
<li>
    <a href="/portal/register">Teacher Registration</a>    
</li>
</ul>   
</li>
@else
    @user
        <li><a href="/home">Dashboard</a></li>
    @enduser
    @auth('admin')
        <li><a href="/admin/home">Dashboard</a></li>
    @endauth
    @auth('teacher')
        <li><a href="/portal/home">Dashboard</a></li>
    @endauth
    @auth('organization')
    <li><a href="/club/home">Dashboard</a></li>
    @endauth
@endguest
    </ul>                      
</nav>              
    <div id="footer-info">Designed by Innovative Fix, LLC</div>
</body>
</html>

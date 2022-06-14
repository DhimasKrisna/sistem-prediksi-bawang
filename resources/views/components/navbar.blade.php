<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">{{auth()->user()->username ?? ''}}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          @auth
              @if(auth()->user()->role == "admin")
                <li class="nav-item">
                  <a class="nav-link" href="{{route('user.index')}}">USER</a>
                </li>
              @endif
          @endauth
          
        </ul>
        @guest
          <div class="d-flex">
            <a href="{{route('login.index')}}" class="btn btn-primary">Login</a>
          </div>      
        @endguest

        @auth
          <div class="d-flex">
            <form  action="{{route('login.logout')}}" method="post">
              @csrf
              <button class="btn btn-danger" type="submit">LogOut</button>
            </form>
          </div>    
        @endauth
        
        
      </div>
    </div>
  </nav>
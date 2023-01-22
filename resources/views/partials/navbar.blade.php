<div class="navbar sticky top-0 shadow-sm bg-base-100 z-50 ">
  <div class="navbar-start">
    {{-- <label tabindex="0" class="btn btn-ghost btn-sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
      </label> --}}
      <label class="btn btn-ghost swap lg:hidden swap-rotate">

        <!-- this hidden checkbox controls the state -->
        <input type="checkbox" class="btn-sidebar" />

        <!-- hamburger icon -->
        <svg class="swap-off fill-current w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>

        <!-- close icon -->
        <svg class="swap-on fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><polygon points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49"/></svg>

      </label>
    <a class="btn btn-ghost no-animation normal-case text-xl">MyStock</a>
    {{-- <img src="{{ asset('image/logo.png') }}" alt="" class="w-24 mx-5 "> --}}
  </div>

  <div class="navbar-end">
    <div class="hidden lg:block">
        @auth
        <span class="mx-5">
            {{Auth::user()->username}}
            -
            <span class="font-semibold
                {{ (Auth::user()->level_user->nama_level === 'admin') ? 'text-red-500' : '' }}
                {{ (Auth::user()->level_user->nama_level === 'manajemen') ? 'text-green-500' : '' }}
                {{ (Auth::user()->level_user->nama_level === 'kaprog') ? 'text-sky-500' : '' }}
            ">
                {{ Auth::user()->level_user->nama_level }}
            </span>
        </span>
        @endauth
    </div>

    {{-- <label class="swap swap-rotate">
        <!-- this hidden checkbox controls the state -->
        <input type="checkbox" data-toggle-theme="light,dark" data-act-class="ACTIVECLASS"/>

        <!-- sun icon -->
        <svg class="swap-on fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>

        <!-- moon icon -->
        <svg class="swap-off fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>

    </label> --}}
    <button data-toggle-theme="light,dark" class="btn btn-sm btn-outline mx-5" data-act-class="ACTIVECLASS">theme</button>

    <form action="/logout" method="POST">
      @csrf

     <div class="dropdown dropdown-end">


      <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
            <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"></path>
              </svg>
        </div>
      </label>
      <a href="https://www.google.com/">

        <ul tabindex="0" class="mt-3 p-3 shadow-lg menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
            @auth
                    <p class="text-base leading-none font-medium">{{Auth::user()->username}}</p>
                    <p class="mb-3 text-sm font-normal
                        {{ (Auth::user()->level_user->nama_level === 'admin') ? 'text-red-500' : '' }}
                        {{ (Auth::user()->level_user->nama_level === 'manajemen') ? 'text-green-500' : '' }}
                        {{ (Auth::user()->level_user->nama_level === 'kaprog') ? 'text-sky-500' : '' }}
                    ">{{Auth::user()->level_user->nama_level}}</p>
                    <div class="mb-4 text-sm font-light">
                        <p>{{Auth::user()->email}}</p>
                    </div>
            @endauth

            <button class="btn btn-sm btn-primary">Logout</button>
        </ul>
    </a>

    </div>
  </div>
</form>
</div>


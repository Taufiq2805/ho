<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
 <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
   <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)" id="hamburger-btn">
     <i class="icon-base ri ri-menu-line icon-md"></i>
   </a>
 </div>
 <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
   <ul class="navbar-nav flex-row align-items-center ms-md-auto">
     <!-- User -->
     <li class="nav-item navbar-dropdown dropdown-user dropdown">
       <a
         class="nav-link dropdown-toggle hide-arrow p-0"
         href="javascript:void(0);"
         data-bs-toggle="dropdown">
         <div class="avatar avatar-online">
           <img src="../assets/img/avatars/1.png" alt="alt" class="rounded-circle" />
         </div>
       </a>
       <ul class="dropdown-menu dropdown-menu-end">
         <li>
           <a class="dropdown-item" href="#">
             <div class="d-flex">
               <div class="flex-shrink-0 me-3">
                 <div class="avatar avatar-online">
                   <img src="../assets/img/avatars/1.png" alt="alt" class="w-px-40 h-auto rounded-circle" />
                 </div>
               </div>
              <div class="flex-grow-1">
                  <h6 class="mb-0">{{ Auth::user()->email }}</h6>
                    <small class="text-body-secondary">{{ Auth::user()->role }}</small>
               </div>  
             </div>
           </a>
         </li>
         <li>
           <div class="dropdown-divider my-1"></div>
         </li>
         <li>
           <div class="dropdown-divider my-1"></div>
         </li>
         <li>
           <div class="d-grid px-4 pt-2 pb-1">
             <a class="btn btn-danger d-flex" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                     {{ __('Logout') }}
                       <i class="ri ri-logout-box-r-line ms-2 ri-xs"></i>
             </a>
             
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                   @csrf
                </form>
           </div>
         </li>
       </ul>
     </li>
     <!--/ User -->
   </ul>
 </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger-btn');
    const menu = document.getElementById('layout-menu');
    const html = document.documentElement;
    const overlay = document.querySelector('.layout-overlay');

    if (hamburger) {
        hamburger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            html.classList.toggle('layout-menu-expanded');
        });
    }

    // Klik overlay = tutup sidebar
    if (overlay) {
        overlay.addEventListener('click', function () {
            html.classList.remove('layout-menu-expanded');
        });
    }

    // Klik di luar sidebar = tutup
    document.addEventListener('click', function (e) {
        if (
            html.classList.contains('layout-menu-expanded') &&
            menu &&
            !menu.contains(e.target) &&
            !e.target.closest('#hamburger-btn')
        ) {
            html.classList.remove('layout-menu-expanded');
        }
    });
});
</script>
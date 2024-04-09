<nav class="sidebar">
    <div class="logo-container">
        <img src="{{ asset('img/AdminLogo.png')}}" alt="">
        <p class="logo-title">Donna Mae Jorge-Hollman <br> Dental Clinic Admin</p>
    </div>
    <ul class="acc-menu">
        <a href="{{ route('admin.schedule-viewer')}}" {{ Request::routeIs('admin.schedule-viewer') ? 'style=text-decoration:underline;' : '' }}>
            <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path class="image" d="M5 12.7595C5 11.4018 5 10.7229 5.27446 10.1262C5.54892 9.52943 6.06437 9.08763 7.09525 8.20401L8.09525 7.34687C9.95857 5.74974 10.8902 4.95117 12 4.95117C13.1098 4.95117 14.0414 5.74974 15.9047 7.34687L16.9047 8.20401C17.9356 9.08763 18.4511 9.52943 18.7255 10.1262C19 10.7229 19 11.4018 19 12.7595V16.9999C19 18.8856 19 19.8284 18.4142 20.4142C17.8284 20.9999 16.8856 20.9999 15 20.9999H9C7.11438 20.9999 6.17157 20.9999 5.58579 20.4142C5 19.8284 5 18.8856 5 16.9999V12.7595Z" stroke-width="2"/>
                <path class="image" d="M14.5 21V16C14.5 15.4477 14.0523 15 13.5 15H10.5C9.94772 15 9.5 15.4477 9.5 16V21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Home
        </a>
        <li class="parent">
            <p>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path class="image" d="M20 12V17C20 18.8856 20 19.8284 19.4142 20.4142C18.8284 21 17.8856 21 16 21H6.5C5.11929 21 4 19.8807 4 18.5V18.5C4 17.1193 5.11929 16 6.5 16H16C17.8856 16 18.8284 16 19.4142 15.4142C20 14.8284 20 13.8856 20 12V7C20 5.11438 20 4.17157 19.4142 3.58579C18.8284 3 17.8856 3 16 3H8C6.11438 3 5.17157 3 4.58579 3.58579C4 4.17157 4 5.11438 4 7V18.5" stroke-width="2"/>
                    <path class="image" d="M9 10L10.2929 11.2929C10.6834 11.6834 11.3166 11.6834 11.7071 11.2929L15 8" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </p>
            @if (Request::routeIs('admin.appointment-scheduler') || Request::routeIs('admin.appointment-request-manager') || Request::routeIs('admin.appointment-manager') || Request::routeIs('admin.appointment-history'))
                <input class="current"  type="checkbox" name="accordion" id="acc-1"/>
            @else
                <input type="checkbox" name="accordion" id="acc-1"/>
            @endif
            <label for="acc-1"></label>
            <ul>
                <li><a href="{{ route('admin.appointment-scheduler')}}" {{ Request::routeIs('admin.appointment-scheduler') ? 'style=text-decoration:underline;' : '' }}>Scheduler</a></li>
                <li><a href="{{ route('admin.appointment-request-manager') }}" {{ Request::routeIs('admin.appointment-request-manager') ? 'style=text-decoration:underline;' : '' }}>Requests</a></li>
                <li><a href="{{ route('admin.appointment-manager') }}" {{ Request::routeIs('admin.appointment-manager') ? 'style=text-decoration:underline;' : '' }}>List</a></li>
                <li><a href="{{ route('admin.appointment-history')}}" {{ Request::routeIs('admin.appointment-history') ? 'style=text-decoration:underline;' : '' }}>History</a></li>
            </ul>
        </li>
        <a href="{{ route('admin.create-appointment')}}" {{ Request::routeIs('admin.create-appointment') ? 'style=text-decoration:underline;' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path class="image1" d="M19.3259 5.77772L18.4944 6.33329V6.33329L19.3259 5.77772ZM19.3259 16.2223L18.4944 15.6667V15.6667L19.3259 16.2223ZM18.2223 17.3259L17.6667 16.4944H17.6667L18.2223 17.3259ZM14 17.9986L13.9956 16.9986C13.4451 17.001 13 17.4481 13 17.9986H14ZM14 18L14.8944 18.4472C14.9639 18.3084 15 18.1552 15 18H14ZM10 18H9C9 18.1552 9.03615 18.3084 9.10557 18.4472L10 18ZM10 17.9986H11C11 17.4481 10.5549 17.001 10.0044 16.9986L10 17.9986ZM5.77772 17.3259L6.33329 16.4944H6.33329L5.77772 17.3259ZM4.67412 16.2223L5.50559 15.6667L5.50559 15.6667L4.67412 16.2223ZM4.67412 5.77772L5.50559 6.33329L4.67412 5.77772ZM5.77772 4.67412L6.33329 5.50559L5.77772 4.67412ZM18.2223 4.67412L17.6667 5.50559L17.6667 5.50559L18.2223 4.67412ZM21 11C21 9.61635 21.0012 8.50334 20.9106 7.61264C20.8183 6.70523 20.6225 5.91829 20.1573 5.22215L18.4944 6.33329C18.7034 6.64604 18.8446 7.06578 18.9209 7.81505C18.9988 8.58104 19 9.57473 19 11H21ZM20.1573 16.7779C20.6225 16.0817 20.8183 15.2948 20.9106 14.3874C21.0012 13.4967 21 12.3836 21 11H19C19 12.4253 18.9988 13.419 18.9209 14.1849C18.8446 14.9342 18.7034 15.354 18.4944 15.6667L20.1573 16.7779ZM18.7779 18.1573C19.3238 17.7926 19.7926 17.3238 20.1573 16.7779L18.4944 15.6667C18.2755 15.9943 17.9943 16.2755 17.6667 16.4944L18.7779 18.1573ZM14.0044 18.9986C15.0785 18.9939 15.9763 18.9739 16.7267 18.8701C17.4931 18.7642 18.1699 18.5636 18.7779 18.1573L17.6667 16.4944C17.3934 16.6771 17.0378 16.8081 16.4528 16.889C15.8518 16.9721 15.0792 16.9939 13.9956 16.9986L14.0044 18.9986ZM15 18V17.9986H13V18H15ZM13.7889 20.6584L14.8944 18.4472L13.1056 17.5528L12 19.7639L13.7889 20.6584ZM10.2111 20.6584C10.9482 22.1325 13.0518 22.1325 13.7889 20.6584L12 19.7639L12 19.7639L10.2111 20.6584ZM9.10557 18.4472L10.2111 20.6584L12 19.7639L10.8944 17.5528L9.10557 18.4472ZM9 17.9986V18H11V17.9986H9ZM5.22215 18.1573C5.83014 18.5636 6.50685 18.7642 7.2733 18.8701C8.02368 18.9739 8.92154 18.9939 9.99564 18.9986L10.0044 16.9986C8.92075 16.9939 8.14815 16.9721 7.54716 16.889C6.96223 16.8081 6.60665 16.6771 6.33329 16.4944L5.22215 18.1573ZM3.84265 16.7779C4.20744 17.3238 4.6762 17.7926 5.22215 18.1573L6.33329 16.4944C6.00572 16.2755 5.72447 15.9943 5.50559 15.6667L3.84265 16.7779ZM3 11C3 12.3836 2.99879 13.4967 3.0894 14.3874C3.18171 15.2948 3.3775 16.0817 3.84265 16.7779L5.50559 15.6667C5.29662 15.354 5.15535 14.9342 5.07913 14.1849C5.00121 13.419 5 12.4253 5 11H3ZM3.84265 5.22215C3.3775 5.91829 3.18171 6.70523 3.0894 7.61264C2.99879 8.50334 3 9.61635 3 11H5C5 9.57473 5.00121 8.58104 5.07913 7.81505C5.15535 7.06578 5.29662 6.64604 5.50559 6.33329L3.84265 5.22215ZM5.22215 3.84265C4.6762 4.20744 4.20744 4.6762 3.84265 5.22215L5.50559 6.33329C5.72447 6.00572 6.00572 5.72447 6.33329 5.50559L5.22215 3.84265ZM11 3C9.61635 3 8.50334 2.99879 7.61264 3.0894C6.70523 3.18171 5.91829 3.3775 5.22215 3.84265L6.33329 5.50559C6.64604 5.29662 7.06578 5.15535 7.81505 5.07913C8.58104 5.00121 9.57473 5 11 5V3ZM13 3H11V5H13V3ZM18.7779 3.84265C18.0817 3.3775 17.2948 3.18171 16.3874 3.0894C15.4967 2.99879 14.3836 3 13 3V5C14.4253 5 15.419 5.00121 16.1849 5.07913C16.9342 5.15535 17.354 5.29662 17.6667 5.50559L18.7779 3.84265ZM20.1573 5.22215C19.7926 4.6762 19.3238 4.20744 18.7779 3.84265L17.6667 5.50559C17.9943 5.72447 18.2755 6.00572 18.4944 6.33329L20.1573 5.22215Z"/>
                <circle class="circle" cx="16" cy="11" r="1" stroke-linecap="round"/>
                <circle class="circle" cx="12" cy="11" r="1" stroke-linecap="round"/>
                <circle class="circle" cx="8" cy="11" r="1"  stroke-linecap="round"/>
            </svg>
            Create Appointment
        </a>
    </ul> 
    <form class="logout" action="{{ route('admin.logout')}}" >
        @csrf
        <button type="submit" class="logout-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <circle class="image" cx="12" cy="12" r="9"  stroke-width="2"/>
                <path class="image" d="M7.5 12H16.5"  stroke-width="2" stroke-linecap="round"/>
            </svg>
            Log Out
        </button>
    </form>          
</nav>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
      --primary-color: #4a90e2;
      --bg-color: #f4f7fa;
      --text-color: #333;
      --sidebar-bg: #ffffff;
      --sidebar-hover: #e6f0ff;
    }
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--bg-color);
      color: var(--text-color);
    }
    .sidebar {
      height: 100%;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: var(--sidebar-bg);
      overflow-y: auto;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      transition: 0.3s;
    }
    .sidebar.closed {
      width: 70px;
    }
    .sidebar-header {
      padding: 10px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #e0e0e0;
      background-color: rgb(112 100 100 / 50%);
      padding-top: 4px;
      padding-bottom: 5px;
    }
    .sidebar-header h3 {
      margin: 0;
      font-size: 1.2em;
      color: var(--primary-color);
    }
    .toggle-btn {
      background: none;
      border: none;
      color: var(--text-color);
      font-size: 20px;
      cursor: pointer;
    }
    .sidebar ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .sidebar a {
      padding: 15px 25px;
      text-decoration: none;
      font-size: 16px;
      color: var(--text-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: 0.2s;
    }
    .sidebar a:hover {
      background-color: var(--sidebar-hover);
      color: var(--primary-color);
    }
    .menu-toggle {
      cursor: pointer;
    }
    .menu-item > .sidebar-dropdown {
      display: none;
      padding-left: 15px;
    }
    .menu-item.show > .sidebar-dropdown {
      display: block;
    }
    #main {
      margin-left: 250px;
      transition: margin-left 0.3s;
    }
    .sidebar.closed ~ #main {
      margin-left: 70px;
    }
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      .sidebar.open {
        width: 250px;
      }
      .sidebar.open ~ #main {
        margin-left: 250px;
      }
      #main {
        margin-left: 70px;
      }
    }
</style>

<div id="mySidebar" class="sidebar">
  <div class="sidebar-header">
    <h3>
      <img src="https://www.absglobaltravel.com/public/images/footer-abs-logo.webp" width="150px" height="50px">
    </h3>
    <button class="toggle-btn" onclick="toggleSidebar()">
      <i class="fas fa-bars" id="toggle-icon"></i>
    </button>
  </div>
  <ul class="menu">
    @php
      $menuItems = isset($menu_nav->json_output)
        ? (is_string($menu_nav->json_output) ? json_decode($menu_nav->json_output, true) : $menu_nav->json_output)
        : [];
    @endphp

    @foreach($menuItems as $item)
      <li class="menu-item {{ request()->routeIs($item['href']) || (isset($item['children']) && collect($item['children'])->pluck('href')->contains(request()->route()->getName())) ? 'show active' : '' }}">
        <a href="{{ $item['href'] ? route($item['href']) : 'javascript:void(0);' }}" class="menu-toggle">
          <div>
            <i class="{{ $item['icon'] ?? 'fas fa-circle' }}"></i>
            <span>{{ $item['text'] }}</span>
          </div>
          @if(!empty($item['children']))
            <i class="fa-solid fa-caret-down"></i>
          @endif
        </a>
        @if(!empty($item['children']))
          <ul class="sidebar-dropdown">
            @foreach($item['children'] as $child)
              <li class="sidebar-dropdown-item {{ request()->routeIs($child['href']) ? 'active' : '' }}">
                <a href="{{ $child['href'] ? route($child['href']) : 'javascript:void(0);' }}">
                  <div>
                    <i class="{{ $child['icon'] ?? 'fas fa-circle' }}"></i>
                    <span>{{ $child['text'] }}</span>
                  </div>
                </a>
              </li>
            @endforeach
          </ul>
        @endif
      </li>
    @endforeach
  </ul>
</div>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('mySidebar');
    const toggleIcon = document.getElementById('toggle-icon');
    sidebar.classList.toggle('closed');
    if (window.innerWidth <= 768) {
      sidebar.classList.toggle('open');
    }

    // Change toggle button icon
    if (sidebar.classList.contains('closed') || sidebar.classList.contains('open')) {
      toggleIcon.classList.toggle('fa-bars');
      toggleIcon.classList.toggle('fa-times');
    }
  }

  document.querySelectorAll('.menu-toggle').forEach(item => {
    item.addEventListener('click', function (event) {
      const parentLi = this.parentElement;
      parentLi.classList.toggle('show');
      event.preventDefault();
    });
  });
</script>

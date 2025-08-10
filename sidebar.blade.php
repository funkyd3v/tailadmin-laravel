<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar z-9999 fixed left-0 top-0 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 lg:static lg:translate-x-0 dark:border-gray-800 dark:bg-black">
    <!-- SIDEBAR HEADER -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="sidebar-header flex items-center gap-2 pb-7 pt-8">
        <a href="index.html">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="dark:hidden" src="{{ asset('assets') }}/images/logo/logo.svg" alt="Logo" />
                <img class="hidden dark:block" src="{{ asset('assets') }}/images/logo/logo-dark.svg" alt="Logo" />
            </span>

            <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="{{ asset('assets') }}/images/logo/logo-icon.svg" alt="Logo" />
        </a>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav x-data="{ selected: $persist('Dashboard') }">
            <!-- Menu Group -->
            <div>
                <ul class="mb-6 flex flex-col gap-4">
                    @foreach ($menus as $menu)
                        {{-- <li class="{{ $menu->children->count() ? 'has-submenu' : '' }}">
                            <a href="{{ $menu->url ? url($menu->url) : '#' }}">
                                @if ($menu->icon)
                                    <i class="{{ $menu->icon }}"></i>
                                @endif
                                <span>{{ $menu->title }}</span>
                            </a>

                            @if ($menu->children->count())
                                <ul class="submenu">
                                    @foreach ($menu->children as $child)
                                        <li><a href="{{ url($child->url) }}">
                                                @if ($child->icon)
                                                    <i class="{{ $child->icon }}"></i>
                                                @endif
                                                {{ $child->title }}
                                            </a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li> --}}
                        <li class="{{ $menu->children->count() ? 'has-submenu' : '' }}">
                            <a href="{{ $menu->url ? url($menu->url) : '#' }}" @click.prevent="selected = (selected === '{{ $menu->title }}' ? '':'{{ $menu->title }}')"
                                class="menu-item group"
                                :class="(selected === '{{ $menu->title }}') ?
                                'menu-item-active' : 'menu-item-inactive'">
                                <svg :class="(selected === '{{ $menu->title }}') ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                                        fill="" />
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    {{ $menu->title }}
                                </span>

                                @if ($menu->children->count())
                                <svg class="menu-item-arrow"
                                    :class="[(selected === '{{ $menu->title }}') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                        sidebarToggle ? 'lg:hidden' : ''
                                    ]"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                @endif
                            </a>

                            <!-- Dropdown Menu Start -->
                            @if ($menu->children->count())
                            <div class="translate transform overflow-hidden"
                                :class="(selected === '{{ $menu->title }}') ? 'block' : 'hidden'">
                                <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                    class="menu-dropdown mt-2 flex flex-col gap-1 pl-9">
                                    @foreach ($menu->children as $child)
                                    <li>
                                        <a href="{{ url($child->url) }}" class="menu-dropdown-item group"
                                            :class="page === 'ecommerce' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            {{ $child->title }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <!-- Dropdown Menu End -->
                        </li>
                    @endforeach

                </ul>
            </div>
        </nav>
        <!-- Sidebar Menu -->
    </div>
</aside>

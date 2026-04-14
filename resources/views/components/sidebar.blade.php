@php
    $menuItems = config('layout.sidebarNavigation', []);
@endphp

<flux:sidebar sticky collapsible="mobile" class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.header>
        <flux:sidebar.brand href="#" logo="https://fluxui.dev/img/demo/logo.png"
            logo:dark="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Arterimpex SRL." />
        <flux:sidebar.collapse class="lg:hidden" />
    </flux:sidebar.header>

    <flux:sidebar.nav>
        @foreach ($menuItems as $menuItem)
            <flux:sidebar.item icon="{{ $menuItem['icon'] }}" href="{{ $menuItem['route'] }}" wire:navigate>
                {{ $menuItem['label'] }}
            </flux:sidebar.item>
        @endforeach
    </flux:sidebar.nav>
    <flux:sidebar.spacer />
    <form action="{{ route('logout.action') }}" method="POST">
        <flux:button size="sm" type="submit"  class="w-full">Log out</flux:button>
    </form>
</flux:sidebar>

<flux:main>
    <flux:heading size="xl" level="1">Good afternoon, Olivia</flux:heading>
    <flux:text class="mb-6 mt-2 text-base">Here's what's new today</flux:text>
    {{-- <flux:separator variant="subtle" /> --}}
    {{ $content }}
</flux:main>

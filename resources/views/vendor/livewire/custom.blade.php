@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Tombol Sebelumnya --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" wire:click="previousPage" rel="prev" aria-label="Previous" style="cursor:pointer;">&lt;</a>
            </li>

            {{-- Tombol Angka --}}
            <ul class="pagination justify-content-center">
                @php
                    $current = $paginator->currentPage();
                    $last = $paginator->lastPage();
                    // Hitung range tombol
                    $start = max(1, $current - 2);
                    $end = min($last, $start + 4);
                    if ($end - $start < 4) {
                        $start = max(1, $end - 4);
                    }
                @endphp

                @for ($i = $start; $i <= $end; $i++)
                    <li class="page-item {{ $i == $current ? 'active' : '' }}">
                        <a class="page-link" wire:click="gotoPage({{ $i }})" style="cursor:pointer;">{{ $i }}</a>
                    </li>
                @endfor
            </ul>

            {{-- Tombol Berikutnya --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" wire:click="nextPage" rel="next" aria-label="Next" style="cursor:pointer;">&gt;</a>
            </li>
        </ul>
    </nav>
@endif

<div class="d-flex justify-content-center my-5">
    <div class="card shadow-sm w-100" style="max-width: {{ $maxWidth ?? '400px' }};">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">{{ $title }}</h5>
            {{ $slot }}
        </div>
    </div>
</div>

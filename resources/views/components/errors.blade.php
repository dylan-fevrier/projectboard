@if (count($errors->all()) > 0)
    <div class="mb-4 w-full bg-error rounded-md">
        <div class="p-4">
            <ul class="list-none">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

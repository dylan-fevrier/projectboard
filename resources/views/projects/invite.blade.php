<div class="card flex flex-col mt-3">
    <h3 class="card-title">
        Invite User
    </h3>
    <div class="text-grey flex-1">
        <form action="{{ $project->path() . '/invitations'}}"  method="post">
            @csrf
            <div class="my-4">
                <input type="email" class="input" placeholder="Email address" name="email">
            </div>
            <button type="submit" class="button button-blue">Invite</button>
        </form>
    </div>
</div>

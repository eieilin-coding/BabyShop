<div>
    <form wire:submit="createNewUser" action="" style="margin-top: 3px">
        <input wire:model="name" type="text" placeholder="name" style="margin-top: 3px"><br>
        @error('name')
            <span class="text-red-500" >{{ $message }}</span><br>
        @enderror
        <input wire:model="email" type="email" placeholder="email" style="margin-top: 3px"><br>
         @error('email')
            <span class="text-red-500" style="margin-top: 3px">{{ $message }}</span><br>
        @enderror
        <input wire:model="password" type="password" placeholder="password" style="margin-top: 3px"><br>
         @error('password')
            <span class="text-red-500">{{ $message }}</span><br>
        @enderror
        <button style="background: cadetblue; width:50px; height: 35px; margin-top:1rem;">Create</button>
    </form>

    <hr>

    @foreach ($users as $user )
       <h3>{{ $user->name }}</h3> 
    @endforeach
</div>

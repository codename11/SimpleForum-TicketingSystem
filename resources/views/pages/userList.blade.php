@extends("layouts.app")

@section("content")
<?php 
//dump($data);
?>
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                @include("inc.listOfUsers")
         
                <div class="card-body">
                    @foreach($data as $item)
                        <?php 
                            $boja = "";
                            if(Auth::check()){
                                $boja = $item->user_id==auth()->user()->id ? "whitesmoke;border-radius: 5px;" : "";
                            }
                            
                        ?>
                        <form class="form dashForm" method="POST" action="/userList/{{$item->user_id}}" style="background-color:{{$boja}}">

                            {{method_field("PATCH")}}
                            @csrf

                            <div class="form-group fGroup">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Name..." value="{{$item->name}}" required @if(Auth::user()->id!==$item->user_id) {{"disabled"}} @endif>
                            </div>

                            <div class="form-group fGroup">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email..." value="{{$item->email}}" required disabled>
                            </div>

                            <div class="form-group fGroup">
                                <select class="form-control" id="sel{{$item->user_id}}" name="role_id">
                                    <option value="" disabled></option>
                                    @foreach ($roles as $role)

                                        <option value="{{$role->id}}" @if($role->id==$item->role_id) {{"selected"}} @endif>{{$role->role}}</option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group fGroup">
                                <input type="number" name="status" class="form-control" min="0" max="1" id="status" placeholder="Status..." value="{{$item->status}}" required @if(Auth::user()->rola->role=="user" || Auth::user()->rola->role=="peon") {{"disabled"}} @endif>
                            </div>

                            <div class="form-group fGroup">
                                <button type="submit" class="btn btn-outline-primary">Update</button>
                            </div>
                            
                        </form>

                        

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
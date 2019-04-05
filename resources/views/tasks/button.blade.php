<!-- form & jeton permettent d'éviter les failles CSRF -->
<form action="{{ $path }}" method="POST">
    {{ csrf_field() }}
    {{ method_field( $method ) }}
    <input type="submit" class="btn" value="@lang($methodName)" />
</form>

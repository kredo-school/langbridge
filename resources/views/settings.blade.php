@extends('layouts.app')

@section('title', 'User Settings')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="settings-card-wrapper p-4 p-md-5">
    <h2>User Settings</h2>
    <form method="POST" action="{{ route('setting.update') }}">
        @csrf
        @method('PUT')

        <div class="card p-4 mb-4 custom-card">
            <h5>Personal Information</h5>

            <div class="mb-3">
                <label for="name" class="form-label">Email</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $user->email }}">
            </div>

            

            <h6 class="mt-4">Personal Information Visibility</h6>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="age_hidden" id="age_hidden" {{ $user->profile->age_hidden ? 'checked' : '' }}>
                <label class="form-check-label mx-1 mt-1" for="age_hidden">Hide Age</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="country_hidden" id="country_hidden" {{ $user->profile->country_hidden ? 'checked' : '' }}>
                <label class="form-check-label mx-1 mt-1" for="country_hidden">Hide Country</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="region_hidden" id="region_hidden" {{ $user->profile->region_hidden ? 'checked' : '' }}>
                <label class="form-check-label mx-1 mt-1" for="region_hidden">Hide Region</label>
            </div>
            <small class="text-muted">*This information will be visible on your public profile if unchecked.</small>
        </div>

        <div class="card p-4 mb-4 custom-card">
            <h5>Search Settings</h5>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hidden" id="hidden" {{ $user->profile->hidden ? 'checked' : '' }}>
                <label class="form-check-label mx-1 mt-1" for="hidden">Hide my profile from search results</label>
            </div>
            <small class="text-muted">*Prevent your profile from appearing in user searches or suggested connections.</small>
        </div>

        <button type="submit" class="btn edit-btn">Save Changes</button>
    </form>

    <hr>

    <div class="text-center mt-5">
        <p>If you wish to delete your account, please click the button below.</p>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
            Delete Account
        </button>
    </div>
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Confirm Account Deletion</h5>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete your account?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <form method="POST" action="{{ route('user.delete') }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger">Delete Account</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

</div>
</div>
@endsection

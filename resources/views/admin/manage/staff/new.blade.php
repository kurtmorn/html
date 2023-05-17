@extends('layouts.admin', [
    'title' => 'New Staff User'
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.manage.staff.create') }}" method="POST">
                @csrf
                <label for="username">Username</label>
                <input class="form-control mb-2" type="text" name="username" placeholder="Username" required>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Item</strong>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_view_item_info">
                            <label class="form-check-label" for="can_view_item_info">Can View Item Info</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_edit_item_info">
                            <label class="form-check-label" for="can_edit_item_info">Can Edit Item Info</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_create_hat_items">
                            <label class="form-check-label" for="can_create_hat_items">Can Create Hat Items</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_create_face_items">
                            <label class="form-check-label" for="can_create_face_items">Can Create Face Items</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_create_gadget_items">
                            <label class="form-check-label" for="can_create_gadget_items">Can Create Gadget Items</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_create_crate_items">
                            <label class="form-check-label" for="can_create_crate_items">Can Create Crate Items</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_create_bundle_items">
                            <label class="form-check-label" for="can_create_bundle_items">Can Create Bundle Items</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <strong>User</strong>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_edit_user_info">
                            <label class="form-check-label" for="can_edit_user_info">Can Edit User Info</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_reset_user_passwords">
                            <label class="form-check-label" for="can_reset_user_passwords">Can Reset User Passwords</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_view_user_info">
                            <label class="form-check-label" for="can_view_user_info">Can View User Info</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_view_user_emails">
                            <label class="form-check-label" for="can_view_user_emails">Can View User Emails</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_give_items">
                            <label class="form-check-label" for="can_give_items">Can Give Items</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_give_currency">
                            <label class="form-check-label" for="can_give_currency">Can Give Currency</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_take_items">
                            <label class="form-check-label" for="can_take_items">Can Take Items</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_take_currency">
                            <label class="form-check-label" for="can_take_currency">Can Take Currency</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_ban_users">
                            <label class="form-check-label" for="can_ban_users">Can Ban Users</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_unban_users">
                            <label class="form-check-label" for="can_unban_users">Can Unban Users</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_ip_ban_users">
                            <label class="form-check-label" for="can_ip_ban_users">Can Ban IPs</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_ip_unban_users">
                            <label class="form-check-label" for="can_ip_unban_users">Can Unban IPs</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <strong>Pending</strong>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_review_pending_assets">
                            <label class="form-check-label" for="can_review_pending_assets">Can Review Pending Assets</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_review_pending_reports">
                            <label class="form-check-label" for="can_review_pending_reports">Can Review Pending Reports</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <strong>Forum</strong>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_edit_forum_posts">
                            <label class="form-check-label" for="can_edit_forum_posts">Can Edit Forum Posts</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_delete_forum_posts">
                            <label class="form-check-label" for="can_delete_forum_posts">Can Delete Forum Posts</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_pin_forum_posts">
                            <label class="form-check-label" for="can_pin_forum_posts">Can Pin Forum Posts</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_lock_forum_posts">
                            <label class="form-check-label" for="can_lock_forum_posts">Can Lock Forum Posts</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <strong>Jobs</strong>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_view_job_listing_responses">
                            <label class="form-check-label" for="can_view_job_listing_responses">Can View Responses</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_create_job_listings">
                            <label class="form-check-label" for="can_create_job_listings">Can Create Listings</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <strong>Management</strong>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_manage_forum_topics">
                            <label class="form-check-label" for="can_manage_forum_topics">Can Manage Forum Topics</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_manage_staff">
                            <label class="form-check-label" for="can_manage_staff">Can Manage Staff</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_manage_site">
                            <label class="form-check-label" for="can_manage_site">Can Manage Site</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <strong>Etc</strong>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="can_render_thumbnails">
                            <label class="form-check-label" for="can_render_thumbnails">Can Render Thumbnails</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-block btn-success mt-1" type="submit">Create</button>
            </form>
        </div>
    </div>
@endsection

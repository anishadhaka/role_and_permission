@extends('layouts.app')

@section('content')
    <h2>Create New Domain</h2>
    
    <form action="{{ route('domain.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="domain_name">Domain Name</label>
                    <input type="text" name="domain_name" class="form-control" id="domain_name" 
                           value="{{ old('domain_name') }}" required>
                </div>

                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" name="company_name" class="form-control" id="company_name" 
                           value="{{ old('company_name') }}" required>
                </div>

                <div class="form-group">
                    <label for="server_address">Server Address</label>
                    <input type="text" name="server_address" class="form-control" id="server_address" 
                           value="{{ old('server_address') }}" required>
                </div>

                <div class="form-group">
                    <label for="port">Port</label>
                    <input type="number" name="port" class="form-control" id="port" 
                           value="{{ old('port') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" 
                           value="{{ old('password') }}" required>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="authentication">Authentication</label>
                    <input type="text" name="authentication" class="form-control" id="authentication" 
                           value="{{ old('authentication') }}" required>
                </div>

                <div class="form-group">
                    <label for="user_name">User Name</label>
                    <input type="text" name="user_name" class="form-control" id="user_name" 
                           value="{{ old('user_name') }}" required>
                </div>

                <div class="form-group">
                    <label for="to_mail_id">To Mail ID</label>
                    <input type="text" name="to_mail_id" class="form-control" id="to_mail_id" 
                           value="{{ old('to_mail_id') }}" required>
                </div>
            </div>
        </div>

        <!-- Rich Text Editors -->
        <div class="form-group">
            <label for="mail_header">Mail Header</label>
            <textarea name="mail_header" class="form-control rich-text-editor" id="mail_header">{{ old('mail_header') }}</textarea>
        </div>

        <div class="form-group">
            <label for="mail_footer">Mail Footer</label>
            <textarea name="mail_footer" class="form-control rich-text-editor" id="mail_footer">{{ old('mail_footer') }}</textarea>
        </div>

        <!-- Action Buttons -->
        <button type="submit" class="btn btn-primary mt-3">Create Domain</button>
        <a href="{{ route('domain.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
@endsection

@section('scripts')
    <!-- Include CKEditor -->
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        // Initialize the rich text editor
        CKEDITOR.replace('mail_header', {
            height: 200
        });
        CKEDITOR.replace('mail_footer', {
            height: 200
        });
    </script>
@endsection

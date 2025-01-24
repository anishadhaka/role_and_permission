@extends('backend.layouts.app')

@section('content')
  <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>

  textarea {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
    margin-bottom: 15px;
  }
  .output {
    margin-top: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fafafa;
    min-height: 100px;
    word-wrap: break-word;
  }

  body #cke_notifications_area_editor1,
  body .cke_notifications_area {
    display: none !important;
  }
</style>

    <h2>Create New Domain</h2>
    
    <form action="{{ route('domain.store') }}" method="POST">
        @csrf

        <div class="row">
            
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
                    <input type="number" name="to_mail_id" class="form-control" id="to_mail_id" 
                           value="{{ old('to_mail_id') }}" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="mail_header">Mail Header</label>

            <textarea name="mail_header" class="form-control" id="mail_header">{{ old('mail_header') }}</textarea>
        </div>

        <div class="form-group">
            <label for="mail_footer">Mail Footer</label>
            <textarea name="mail_footer" class="form-control" id="mail_footer">{{ old('mail_footer') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Domain</button>
        <a href="{{ route('domain.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>

    <script>
    $(document).ready(function () {
      // Initialize CKEditor with custom toolbar
      CKEDITOR.replace("mail_header", {
        height: 300,
        toolbar: [
          {
            name: "clipboard",
            items: ["Cut", "Copy", "Paste", "Undo", "Redo"],
          },
          { name: "editing", items: ["Find", "Replace", "SelectAll"] },
          {
            name: "basicstyles",
            items: ["Bold", "Italic", "Underline", "Strike", "RemoveFormat"],
          },
          {
            name: "paragraph",
            items: [
              "NumberedList",
              "BulletedList",
              "-",
              "Outdent",
              "Indent",
              "-",
              "Blockquote",
            ],
          },
          {
            name: "insert",
            items: ["Image", "Table", "HorizontalRule", "SpecialChar"],
          },
          { name: "tools", items: ["Maximize", "ShowBlocks"] },
        ],
      });

      // Display content in the output div when "Get Content" is clicked
      $("#getContent").click(function () {
        var editorData = CKEDITOR.instances.mail_header.getData();
        $("#output").html(editorData || "<em>No content to display.</em>");
      });
    });
  </script>
@endsection




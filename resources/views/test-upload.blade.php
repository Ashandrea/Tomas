<!DOCTYPE html>
<html>
<head>
    <title>Test File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Test File Upload</h1>
        
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('test.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select file to upload (max 2MB)</label>
                <input type="file" name="file" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100">
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Upload File
                </button>
            </div>
        </form>

        <div class="mt-8 p-4 bg-gray-50 rounded-md">
            <h2 class="text-lg font-semibold mb-2">Current PHP Settings:</h2>
            <ul class="text-sm space-y-1">
                <li>upload_max_filesize: {{ ini_get('upload_max_filesize') }}</li>
                <li>post_max_size: {{ ini_get('post_max_size') }}</li>
                <li>memory_limit: {{ ini_get('memory_limit') }}</li>
                <li>max_file_uploads: {{ ini_get('max_file_uploads') }}</li>
                <li>max_execution_time: {{ ini_get('max_execution_time') }}</li>
                <li>max_input_time: {{ ini_get('max_input_time') }}</li>
            </ul>
        </div>
    </div>
</body>
</html>

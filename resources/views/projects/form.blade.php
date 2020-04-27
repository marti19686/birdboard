@csrf

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title" class="label">Title</label>

    <div class="control">
        <input
            type="text"
            class="input bg-transparent border-gray-400 rounded p-2 text-xs w-full"
            name="title"
            required
            placeholder="My next awesome project"
            value="{{ $project->title }}">

    </div>
</div>

<div class="field">
    <label for="description" class="label text-sm mb-2 block">Description</label>

    <div class="control">
        <textarea
            name="description"
            rows="10"
            class="textarea bg-transparent border-gray-400 rounded p-2 text-xs w-full"
            placeholder="I should start describe my project!"
            required>
                {{ $project->description }}
            </textarea>
    </div>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button is-link mr-2">{{ $buttonText }}</button>

        <a href="{{ $project->path() }}"> Cancel</a>
    </div>
</div>

@if ($errors->any())
    <div class="field mt-6">
        @foreach($errors->all() as $error)
            <li class="text-sm text-red-600 ">{{ $error }}</li>
        @endforeach
    </div>
@endif

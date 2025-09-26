@props(['user' => null])


<div class="space-y-4">
<div>
<label class="block text-sm font-medium mb-1">Name</label>
<input name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full rounded border-gray-300" required />
@error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>


<div>
<label class="block text-sm font-medium mb-1">Email</label>
<input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full rounded border-gray-300" required />
@error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>


<div>
<label class="block text-sm font-medium mb-1">Password {{ isset($user) ? '(leave blank to keep current)' : '' }}</label>
<input type="password" name="password" class="w-full rounded border-gray-300" {{ isset($user) ? '' : 'required' }} />
@error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>


<div>
<label class="block text-sm font-medium mb-1">Confirm Password</label>
<input type="password" name="password_confirmation" class="w-full rounded border-gray-300" {{ isset($user) ? '' : 'required' }} />
</div>
</div>

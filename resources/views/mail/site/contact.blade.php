<x-mail::message>
    <x-slot name="subject">New Contact Message</x-slot>

    <x-slot name="header">
        <h1>New Contact Message</h1>
    </x-slot>

    <x-slot name="body">
        <p><strong>Name:</strong> {{ $message->name }}</p>
        <p><strong>Email:</strong> {{ $message->email }}</p>
        <p><strong>Message:</strong> {{ $message->message }}</p>
    </x-slot>
</x-mail::message>

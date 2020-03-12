<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v1.9.4/dist/alpine.js" defer></script>
    <style>
        .active {
            background: red;
        }
    </style>
</head>
<body>
    <div x-data="{name: ''}">
        <label for="name">Name:</label>
        <input type="text" id="name" x-model="name">
        <p x-text="name"></p>
    </div>

    <div x-data="{show: false}">
        <button @click="show = !show"
                :aria-expanded="show ? 'true' : 'false'"
                :class="{'active': show}"
        >Toggle Button</button>
        <div x-show="show">Hello World</div>
    </div>

    <div x-data>
        <span x-ref="foo"></span>
        <button class="btn btn-dark" @click="$refs.foo.innerText = 'Smashing Magazine'">Click me</button>
    </div>

    <div x-data>
        <button class="btn btn-secondary" @click="$el.innerHTML = 'Smashing Magazine'">Click me</button>
    </div>

    <div x-data="{ text: 'Click me' }">
        <button class="btn btn-primary" @click="
                text = 'Clicked';
                $nextTick(() => {
                        // This will output 'Clicked', not 'Click me'
                        console.log($event.target.innerText)
                });" x-text="text"></button>
    </div>
</body>
</html>

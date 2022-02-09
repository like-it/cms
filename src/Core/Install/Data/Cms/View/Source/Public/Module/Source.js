let php = {};

php.replace = [
    {
        "search" : "class ",
        "replace": "<span class=\"code-php-class\">class </span>"
    },
    {
        "search" : "<?php",
        "replace": "<span class=\"code-php-start\">&lt;&quest;php</span>"
    },
    {
        "search" : "namespace ",
        "replace": "<span class=\"code-php-namespace\">namespace </span>"
    },
    {
        "search" : "use ",
        "replace": "<span class=\"code-php-use\">use </span>"
    },
    {
        "search" : "extends ",
        "replace": "<span class=\"code-php-extends\">extends </span>"
    },
    {
        "search" : "private ",
        "replace": "<span class=\"code-php-private\">private </span>"
    },
    {
        "search" : "protected ",
        "replace": "<span class=\"code-php-protected\">protected </span>"
    },
    {
        "search" : "public ",
        "replace": "<span class=\"code-php-public\">public </span>"
    },
    {
        "search" : "const ",
        "replace": "<span class=\"code-php-const\">const </span>"
    },
    {
        "search" : "{",
        "replace": "<span class=\"code-php-curly-open\">&#123;</span>"
    },
    {
        "search" : "}",
        "replace": "<span class=\"code-php-curly-close\">&#125;</span>"
    }
];

export { php };
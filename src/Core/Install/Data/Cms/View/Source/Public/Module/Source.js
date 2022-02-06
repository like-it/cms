let php = {};

php.replace = [

    {
        "search" : "class",
        "replace": "<span class=\"code-php-class\">class</span>"
    },
    {
        "search" : "&#60;&#63;&#112;&#104;&#112;",
        "replace": "<span class=\"code-php-start\">&#60;&#63;&#112;&#104;&#112;</span>"
    },
    {
        "search" : "namespace",
        "replace": "<span class=\"code-php-namespace\">namespace</span>"
    },
    {
        "search" : "use",
        "replace": "<span class=\"code-php-use\">use</span>"
    },
    {
        "search" : "extends",
        "replace": "<span class=\"code-php-extends\">extends</span>"
    },
    {
        "search" : "private",
        "replace": "<span class=\"code-php-private\">private</span>"
    },
    {
        "search" : "protected",
        "replace": "<span class=\"code-php-protected\">protected</span>"
    },
    {
        "search" : "public",
        "replace": "<span class=\"code-php-public\">public</span>"
    },
    {
        "search" : "const",
        "replace": "<span class=\"code-php-const\">const</span>"
    },
    {
        "search" : "&lbrace;",
        "replace": "<span class=\"code-php-curley-open\">&lbrace;</span>"
    },
    {
        "search" : "&rcub;",
        "replace": "<span class=\"code-php-curley-close\">&rcub;</span>"
    }

];

export { php };
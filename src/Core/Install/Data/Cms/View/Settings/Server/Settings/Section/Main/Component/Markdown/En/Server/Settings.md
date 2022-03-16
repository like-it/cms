##### Server settings

The server settings can be configured here.  
Warning, changes to these files can cause a corrupt system.   
This means that the whole system cannot be reached if you make one of these files corrupt.  
Gladfully you can restore these files if necessary in the cli (command line interface). 

```bash
funda restore .htaccess  
funda restore index.php
```

These files aren't imported or exported from the system.

Files available here are system-wide available. 
It can be convenient to have files here which are used on multiple domains and you don't wan't to have duplicate code on every domain.  
Be aware that file-lookup is in a certain hierarchy. domain specific files are loaded before server files. (Server files are last in order).



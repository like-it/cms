{$installation.email = terminal.readline('E-mail: ')}
{while(true)}
{$installation.password = terminal.readline('Password: ', 'hidden')}
{$installation.again = terminal.readline('Password again: ', 'hidden')}
{if($installation.password === $installation.again)}
{break()}
{else}
Password mismatch.
{/if}
{/while}
{$installation.domain = terminal.readline('Domain: ')}
{system.install($installation)}
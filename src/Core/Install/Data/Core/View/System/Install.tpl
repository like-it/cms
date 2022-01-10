{$installation.email = terminal.readline('E-mail: ')}
{$installation.password = terminal.readline('Password: ', 'hidden')}
{$installation.again = terminal.readline('Password again: ', 'hidden')}
{$installation.domain = terminal.readline('Domain: ')}
{system.install($installation)}
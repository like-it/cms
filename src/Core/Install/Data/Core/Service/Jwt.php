<?php
/**
 * (c) Remco van der Velde
 */
namespace Host\Subdomain\Host\Extension\Service;

use stdClass;
use DateTimeImmutable;
use DateTimeZone;

use Lcobucci\Clock\SystemClock;
//use Lcobucci\JWT\Token\Signature;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;

use R3m\Io\Exception\AuthenticationException;
use R3m\Io\Exception\AuthorizationException;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key\LocalFileReference;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;

use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;

class Jwt {

    const FIELD = [
        'token.private.key' => 'token.private_key',
        'token.certificate' => 'token.certificate',
        'token.passphrase' => 'token.passphrase',
        'token.issued.by' => 'token.issued_by',
        'token.issued.at' => 'token.issued_at',
        'token.permitted.for' => 'token.permitted_for',
        'token.identified.by' => 'token.identified_by',
        'token.can.only.be.used.after' => 'token.can_only_be_used_after',
        'token.expires.at' => 'token.expires_at',
        'refresh.token.private.key' => 'refresh.token.private_key',
        'refresh.token.certificate' => 'refresh.token.certificate',
        'refresh.token.passphrase' => 'refresh.token.passphrase',
        'refresh.token.issued.by' => 'refresh.token.issued_by',
        'refresh.token.issued.at' => 'refresh.token.issued_at',
        'refresh.token.permitted.for' => 'refresh.token.permitted_for',
        'refresh.token.identified.by' => 'refresh.token.identified_by',
        'refresh.token.can.only.be.used.after' => 'refresh.token.can_only_be_used_after',
        'refresh.token.expires.at' => 'refresh.token.expires_at'
    ];


    public static function get(App $object, Configuration $configuration, $options=[]){
        $url = $object->config('project.dir.data') . 'Config.json';
        $config  = $object->parse_read($url, sha1($url));
        $user = false;
        if(array_key_exists('user', $options)){
            $user = $options['user'];
            unset($user->password);
            unset($user->profile);
            unset($user->parameter);
            unset($user->refreshToken);
        }
        $now = new DateTimeImmutable();
        return $configuration->builder()
            // Configures the issuer (iss claim)
            ->issuedBy($config->get('token.issued_by'))
            // Configures the audience (aud claim)
            ->permittedFor($config->get('token.permitted_for'))
            // Configures the id (jti claim)
            ->identifiedBy($config->get('token.identified_by'))
            // Configures the time that the token was issue (iat claim)
            ->issuedAt($now->modify($config->get('token.issued_at')))
            // Configures the time that the token can be used (nbf claim)
            ->canOnlyBeUsedAfter($now->modify($config->get('token.can_only_be_used_after')))
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($now->modify($config->get('token.expires_at')))
            // Configures a new claim
            ->withClaim('user', $user)
            // Builds a new token
            ->getToken($configuration->signer(), $configuration->signingKey());
    }

    public static function refresh_get(App $object, Configuration $configuration, $options=[]){
        $url = $object->config('project.dir.data') . 'Config.json';
        $config  = $object->parse_read($url, sha1($url));
        $user = false;
        if(
            array_key_exists('user', $options) &&
            property_exists($options['user'], 'uuid')
        ){
            $user = new stdClass();
            $user->uuid = $options['user']->uuid;
        }
        $now = new DateTimeImmutable();
        return $configuration->builder()
            // Configures the issuer (iss claim)
            ->issuedBy($config->get('refresh.token.issued_by'))
            // Configures the audience (aud claim)
            ->permittedFor($config->get('refresh.token.permitted_for'))
            // Configures the id (jti claim)
            ->identifiedBy($config->get('refresh.token.identified_by'))
            // Configures the time that the token was issue (iat claim)
            ->issuedAt($now->modify($config->get('refresh.token.issued_at')))
            // Configures the time that the token can be used (nbf claim)
            ->canOnlyBeUsedAfter($now->modify($config->get('refresh.token.can_only_be_used_after')))
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($now->modify($config->get('refresh.token.expires_at')))
            // Configures a new header
            ->withHeader('user', $user)
            // Builds a new token
            ->getToken($configuration->signer(), $configuration->signingKey());
    }

    public static function configuration(App $object, $options=[]){
        $url = $object->config('project.dir.data') . 'Config.json';
        $config  = $object->parse_read($url, sha1($url));
        dd($config->data());
        if(
            array_key_exists('refresh', $options) &&
            $options['refresh'] === true
        ){
            $configuration = Configuration::forAsymmetricSigner(
            // You may use RSA or ECDSA and all their variations (256, 384, and 512) and EdDSA over Curve25519
                new Signer\Rsa\Sha256(),
                LocalFileReference::file($config->get('refresh.token.private_key')),
                LocalFileReference::file($config->get('refresh.token.certificate'))
//            InMemory::plainText($config->get('jwt.passphrase'))
            );
        } else {
            $configuration = Configuration::forAsymmetricSigner(
            // You may use RSA or ECDSA and all their variations (256, 384, and 512) and EdDSA over Curve25519
                new Signer\Rsa\Sha256(),
                LocalFileReference::file($config->get('token.private_key')),
                LocalFileReference::file($config->get('token.certificate'))
//            InMemory::plainText($config->get('jwt.passphrase'))
            );
        }
        assert($configuration instanceof Configuration);
        return $configuration;
    }

    public static function request(App $object){
        $request = new Data($object->request());
        $data = new Data();
        foreach(Jwt::FIELD as $key => $attribute){
            if($request->get($key)){
                $data->set($attribute, $request->get($key));
            }
        }
        return $data;
    }

    /*
    public static function refresh_token(App $object, $options=[]){
        //bug returns {}
        $token = '';
        if(isset($_SERVER['HTTP_AUTHORIZATION'])){
            $token = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])){
            $token = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        $token = substr($token , 7);
        if(empty($token)){
            $error = [];
            $error['error'] = [];
            $error['error']['authentication'] = 'Authentication failure...';
            return $error;
        }
        elseif($token==='null'){
            $error = [];
            $error['error'] = [];
            $error['error']['authentication'] = 'Token failure...';
            return $error;
        }
        $url = $object->config('project.dir.data') . 'Config.json';
        $config  = $object->parse_read($url, sha1($url));
        $options['refresh'] = true;
        $configuration = Jwt::configuration($object, $options);
        assert($configuration instanceof Configuration);
        $token_unencrypted = $configuration->parser()->parse($token);
        assert($token_unencrypted instanceof UnencryptedToken);
        $clock = SystemClock::fromUTC(); // use the clock for issuing and validation
        //dd($config->get('refresh.token.certificate'));
        $configuration->setValidationConstraints(
            new IssuedBy($config->get('refresh.token.issued_by')),
            new IdentifiedBy($config->get('refresh.token.identified_by')),
            new PermittedFor($config->get('refresh.token.permitted_for')),
            new SignedWith(new Signer\Rsa\Sha256(), LocalFileReference::file($config->get('refresh.token.certificate'))),
            new StrictValidAt($clock),
            new LooseValidAt($clock)
        );
        $constraints = $configuration->validationConstraints();
        if (! $configuration->validator()->validate($token_unencrypted, ...$constraints)) {
            $error = [];
            $error['error'] = [];
            $error['error']['authentication'] = 'Authentication failure...';
            return $error;
        }
//        die('endtest');
        $headers = $token_unencrypted->headers();
        if($headers->has('user')){
            $user =  $headers->get('user');
            if(array_key_exists('uuid', $user)){
                $user = User::find($object, $user);
                $refreshToken = sha1($token);
                if(!password_verify($refreshToken, $user->getRefreshToken())){
                    $error = [];
                    $error['error'] = [];
                    $error['error']['authentication'] = 'Authentication failure...';
                    return $error;
                }
                if(!$user->getIsActive()){
                    $error = [];
                    $error['error'] = [];
                    $error['error']['authentication'] = 'User is not active...';
                    return $error;
                }
                if($user->getIsDeleted()){
                    $error = [];
                    $error['error'] = [];
                    $error['error']['authentication'] = 'User is deleted...';
                    return $error;
                }
                $options_expose = [];
                $options_expose['user'] = $user;
                $options_expose['response'] = 'json';
                $expose = $user->expose($object, $options_expose);
                if($expose == '{}'){
                    $error = [];
                    $error['error'] = [];
                    $error['error']['authentication'] = 'User is gone...';
                    return $error;
                }
                return $expose;
            } else {
                $error = [];
                $error['error'] = [];
                $error['error']['authentication'] = 'No Uuid found in user...';
                return $error;
            }
        } else {
            $error = [];
            $error['error'] = [];
            $error['error']['authentication'] = 'Header failure...';
            return $error;
        }
    }

    public static function authenticate(App $object, $options=[]){
        $token = '';
        if(isset($_SERVER['HTTP_AUTHORIZATION'])){
            $token = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])){
            $token = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        $token = substr($token , 7);
        if(empty($token)){
            throw new AuthenticationException('Authentication failure...');
        }
        $url = $object->config('project.dir.data') . 'Config.json';
        $config  = $object->parse_read($url, sha1($url));
        $configuration = Jwt::configuration($object, $options);
        assert($configuration instanceof Configuration);
        $token_unencrypted = $configuration->parser()->parse($token);
        assert($token_unencrypted instanceof UnencryptedToken);
        $clock = SystemClock::fromUTC(); // use the clock for issuing and validation
        $configuration->setValidationConstraints(
            new IssuedBy($config->get('token.issued_by')),
            new IdentifiedBy($config->get('token.identified_by')),
            new PermittedFor($config->get('token.permitted_for')),
            new SignedWith(new Signer\Rsa\Sha256(), LocalFileReference::file($config->get('token.certificate'))),
            new StrictValidAt($clock),
            new LooseValidAt($clock)
        );
        $constraints = $configuration->validationConstraints();
        if (!$configuration->validator()->validate($token_unencrypted, ...$constraints)) {
            $error = [];
            $error['error'] = [];
            $error['error']['authentication'] = 'Authentication failure...';
            return $error;
        }
        $headers = $token_unencrypted->headers();
        if($headers->has('user')){
            $user =  $headers->get('user');
            if(empty($user['isActive'])){
                throw new AuthenticationException('User is not active...');
            }
            if(!empty($user['isDeleted'])){
                throw new AuthenticationException('User is deleted...');
            }
            if(count($user['role']) == 0){
                throw new AuthenticationException('User has no roles...');
            }
            $user['token'] = $token;
            //$user = User::addRefreshToken($object, $user);
            //$user = User::addKey($object, $user);
            return $user;
        }
    }
    */
}
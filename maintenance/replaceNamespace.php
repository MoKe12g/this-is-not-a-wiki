<?php

namespace MediaWiki\Extension\ThisIsNotAWiki;

use Maintenance;
use MediaWiki\MediaWikiServices;

$IP = strval( getenv( 'MW_INSTALL_PATH' ) ) !== ''
	? getenv( 'MW_INSTALL_PATH' )
	: realpath( __DIR__ . '/../../../' );

require_once "$IP/maintenance/Maintenance.php";

class ReplaceNamespace extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addDescription( 'Replace the "ns:" prefix with readable text' );
		$this->addArg( 'path', 'Path to the directory html files locate' );
	}

	public function execute() {
		$path = $this->getArg( 0 );
		if ( str_ends_with( $path, '/' ) ) {
			$path = rtrim( $path, '/' );
		}

		foreach ( glob( "$path/ns*" ) as $filename ) {
			$basename = basename( $filename );
			if ( !preg_match( '/^ns(\d+)%3A/', $basename, $matches ) ) {
				$this->output( "$basename is not matched\n" );
				continue;
			}

			$ns = $matches[1];
			if ( !ctype_digit( $ns ) ) {
				$this->output( "$ns is a number\n" );
				continue;
			}

			$nsText = MediaWikiServices::getInstance()->getContentLanguage()->getNsText( $ns );
			$newName = preg_replace( "/^ns$ns%3A/", "$nsText:", $basename );
			$newName = ltrim( $newName, ':' );
			rename( "$path/$basename", "$path/$newName" );
		}
	}
}

$maintClass = ReplaceNamespace::class;
require_once RUN_MAINTENANCE_IF_MAIN;

# 🏥 MediSync (Health-Log App)
> 複数医療機関の処方を一括管理する、患者主体の服薬アドヒアランス向上プラットフォーム

[![Laravel](https://img.shields.io/badge/Laravel-13.4-FF2D20?logo=laravel&style=flat-square)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?logo=php&style=flat-square)](https://www.php.net/)
[![Docker](https://img.shields.io/badge/Infrastructure-Docker_Sail-2496ED?logo=docker&style=flat-square)](https://www.docker.com/)

## 📋 プロジェクト概要
複数の病院・診療科を跨いで処方される薬剤情報を一元管理し、「飲み忘れ」や「情報の分断」を防ぐためのWebアプリケーションです。
単なる記録ツールではなく、医療データの整合性を保つためのリレーションシップ設計に重点を置いています。

## 🛠 技術スタック
- **Backend**: PHP 8.5 (Latest) / Laravel 13.4
- **Frontend**: Tailwind CSS / Blade Templates
- **Database**: MySQL 8.0 (HeidiSQL for GUI)
- **Infrastructure**: Docker (Laravel Sail) / Ubuntu (WSL2)
- **Testing**: PHPUnit / Pest (予定)

## 🏗 システム設計 (System Architecture)

### データ構造
医療情報の整合性を担保するため、以下の正規化された4階層リレーションを採用しています。
- **Hospitals** (病院)
- └── **Departments** (診療科)
-     └── **Prescriptions** (処方箋：受診日単位)
-         └── **Medicines** (薬剤)
-             └── **TakingLogs** (服用履歴)

### 実装のこだわり
- **Eager Loadingの徹底**: `with()` メソッドを用いた先行読み込みにより、階層構造特有のN+1問題を根本から解決し、パフォーマンスを最適化。
- **カプセル化された判定ロジック**: モデル内に `isTakenToday()` 等のドメインロジックを実装し、コントローラーの肥大化（Fat Controller）を防止。

## 🚀 開発ログ & 技術的課題へのアプローチ

### 1. 医療データの完全性の保護 (Mass Assignment)
- **課題**: 不正なリクエストによるデータ改ざんリスク。
- **解決**: `$fillable` によるホワイトリスト方式を採用。セキュリティを意識したデータ投入フローを構築。

### 2. コンテキストを維持するUX設計
- **課題**: ステートレスなWeb環境での「どの処方箋への薬登録か」という文脈維持。
- **解決**: クエリパラメータによる `prescription_id` の委譲。ユーザーの迷いを排除する動的なルーティング設計。

### 3. 多重服用記録の防止ロジック
- **課題**: ボタン連打によるDBデータの不整合。
- **解決**: Eloquentリレーションを用いた当日の服用存在チェックを実装。フロントエンド側でUIを「済」状態へ動的に切り替え、整合性を担保。

## 🔧 環境構築
```bash
git clone [repository-url]
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
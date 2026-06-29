# 🏥 MediSync (Health-Log App)
> 複数医療機関の処方を一括管理する、患者主体の服薬アドヒアランス向上プラットフォーム

[![Laravel](https://img.shields.io/badge/Laravel-13.4-FF2D20?logo=laravel&style=flat-square)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?logo=php&style=flat-square)](https://www.php.net/)
[![Docker](https://img.shields.io/badge/Infrastructure-Docker_Sail-2496ED?logo=docker&style=flat-square)](https://www.docker.com/)

## 📋 プロジェクト概要
複数の病院・診療科を跨いで処方される薬剤情報を一元管理し、「飲み忘れ」や「情報の分断」を防ぐためのWebアプリケーションです。
さらに、患者のQOL向上を目的とし、服薬管理だけでなく「体重・血圧・血糖値」を一括して記録・管理できるバイタルログ機能とのクロスアプリケーション連携を備えています。

## 🛠 技術スタック
- **Backend**: PHP 8.5 / Laravel 13.4
- **Frontend**: Tailwind CSS / Blade Templates
- **Database**: MySQL 8.0 (HeidiSQL for GUI)
- **Infrastructure**: Docker (Laravel Sail) / Ubuntu (WSL2)
- **Tooling**: Doctrine DBAL (DBスキーマ変更用)

## 🏗 システム設計 (System Architecture)

### 1. データ構造
医療情報・体調記録の整合性を担保するため、以下のリレーションを採用しています。
- **Hospitals** (病院) └── **Departments** (診療科) └── **Prescriptions** (処方箋) └── **Medicines** (薬剤) └── **TakingLogs** (服用履歴：秒単位記録)
- **Vitals** (バイタルログ：体重、最高/最低血圧、血糖値の一括管理テーブル)

### 2. コンポーネント指向を意識した2カラムUI
日常のメイン行動である「服用・確認（タイムライン）」と、管理機能である「マスタ登録・変更・削除（CRUD）」の導線を分離。認知負荷を最小限に抑えるプロ仕様の2カラムレイアウトを採用。

## 🚀 開発ログ & 技術的課題へのアプローチ

### 1. 医療データの正確性担保（時分秒のデータ消失バグの解決）
- **課題**: 保存された服用履歴（TakingLogs）の時刻がすべて `00:00` に丸められてしまい、正確な服薬時間が記録できない。
- **解決**: 原因がデータベースの `DATE` 型にあると特定。`doctrine/dbal` パッケージを導入し、既存データを保護しつつカラム型を `DATETIME`（日時）型へ安全に変更するマイグレーションを計画・実行。これにより「秒単位の正確性」を担保した。

### 2. クロスアプリケーション連携（服薬 ⇄ 体調管理の一括登録）
- **課題**: 将来的なマイクロサービス化（アプリ分離）を見据えつつ、ユーザーが迷わないシームレスな画面遷移とデータ保存を実現する必要性。
- **解決**: 服薬（青）と体調管理（緑）でブランドカラーを明確に分けたUXを設計。`VitalController` を新設し、体重（小数点第一位）、血圧、血糖値をワンアクションで一括保存（Mass Assignment）するロジックを構築。

### 3. 医療・健康データにおけるバリデーションの徹底
- **課題**: 不正なリクエストや、健康データとしてあり得ない異常値（例: 体重500kgなど）の混入によるシステム信頼性の低下。
- **解決**: サーバーサイド（Laravel）で厳格な `between` 構文を用いた数値範囲バリデーションを実装。データの堅牢性を大幅に向上。

### 4. Eager Loadingによるパフォーマンス最適化
- **課題**: 医療データ特有の多階層リレーションによるN+1問題の発生。
- **解決**: コントローラー側で `with(['department.hospital', 'medicines.takingLogs'])` を用いた先行読み込みを徹底し、クエリ発行回数を最小限に抑制。

## 🔧 環境構築
```bash
git clone [repository-url]
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail composer require doctrine/dbal
./vendor/bin/sail artisan migrate --seed
[Setup]
AppName=Alarm Clock by GSG
AppVersion=1.0
AppCopyright=© 2025 GSG. All rights reserved.
AppPublisher=GSG Development

DefaultDirName={pf}\Alarm Clock GSG
DefaultGroupName=Alarm Clock GSG
DisableDirPage=no
DisableProgramGroupPage=no

OutputBaseFilename=Installer-AlarmClock-GSG-v1.0
Compression=lzma
SolidCompression=yes
OutputDir=.

PrivilegesRequired=admin
PrivilegesRequiredOverridesAllowed=dialog

WizardStyle=modern

LanguageDetectionMethod=uilanguage
ShowLanguageDialog=yes

DisableReadyPage=no
DisableFinishedPage=no

AllowCancelDuringInstall=yes
Uninstallable=yes
UsePreviousAppDir=yes

AlwaysShowDirOnReadyPage=yes


[Files]
; Salin semua file dari folder "Alarm" ke direktori instalasi
Source: "Alarm\*"; DestDir: "{app}"; Flags: ignoreversion recursesubdirs createallsubdirs

; Salin file uninstaller (otomatis ditambahkan oleh Inno Setup)
[Icons]
Name: "{group}\Alarm Clock GSG"; Filename: "{app}\GrahaSaranaAlarm.exe"; WorkingDir: "{app}"; IconFilename: "{app}\GrahaSaranaAlarm.exe"
Name: "{commondesktop}\Alarm Clock GSG"; Filename: "{app}\GrahaSaranaAlarm.exe"; WorkingDir: "{app}"; IconFilename: "{app}\GrahaSaranaAlarm.exe"; OnlyBelowVersion: 0,0

[Run]
; Jalankan aplikasi setelah instalasi selesai
Filename: "{app}\GrahaSaranaAlarm.exe"; Description: "Jalankan Alarm Clock setelah instalasi"; Flags: nowait postinstall skipifsilent

; Cegah instalasi ganda
[Code]
var
  AlreadyInstalled: Boolean;

function InitializeSetup(): Boolean;
begin
  AlreadyInstalled := RegKeyExists(HKLM, 'SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\AlarmClockGSG');
  if AlreadyInstalled then
  begin
    MsgBox('Aplikasi ini sudah terinstal di sistem Anda.', mbInformation, MB_OK);
    Result := False;
  end else
    Result := True;
end;

procedure CurStepChanged(CurStep: TSetupStep);
begin
  if CurStep = ssPostInstall then
  begin
    MsgBox('Terima kasih telah menginstal Alarm Clock by GSG! 🎉', mbInformation, MB_OK);
  end;
end;
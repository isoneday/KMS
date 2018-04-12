'* Usage: Drop .xl* files on me to export each sheet as CSV

'* Global Settings and Variables
Dim gSkip
Set args = Wscript.Arguments

For Each sFilename In args
    iErr = ExportExcelFileToCSV(sFilename)
    ' 0 for normal success
    ' 404 for file not found
    ' 10 for file skipped (or user abort if script returns 10)
Next

WScript.Quit(0)

Function ExportExcelFileToCSV(sFilename)
    '* Settings
    Dim oExcel, oFSO, oExcelFile
    Set oExcel = CreateObject("Excel.Application")
    Set oFSO = CreateObject("Scripting.FileSystemObject")
    iCSV_Format = 6

    '* Set Up
    sExtension = oFSO.GetExtensionName(sFilename)
    if sExtension = "" then
        ExportExcelFileToCSV = 404
        Exit Function
    end if
    sTest = Mid(sExtension,1,2) '* first 2 letters of the extension, vb's missing a Like operator
    if not (sTest =  "xl") then
        if (PromptForSkip(sFilename,oExcel)) then
            ExportExcelFileToCSV = 10
            Exit Function
        end if
    End If
    sAbsoluteSource = oFSO.GetAbsolutePathName(sFilename)
    sAbsoluteDestination = Replace(sAbsoluteSource,sExtension,"{sheet}.csv")

    '* Do Work
    Set oExcelFile = oExcel.Workbooks.Open(sAbsoluteSource)
    For Each oSheet in oExcelFile.Sheets
        sThisDestination = Replace(sAbsoluteDestination,"{sheet}",oSheet.Name)
        oExcelFile.Sheets(oSheet.Name).Select
        oExcelFile.SaveAs sThisDestination, iCSV_Format
    Next

    '* Take Down
    oExcelFile.Close False
    oExcel.Quit

    ExportExcelFileToCSV = 0
    Exit Function
End Function

Function PromptForSkip(sFilename,oExcel)
    if not (VarType(gSkip) = vbEmpty) then
        PromptForSkip = gSkip
        Exit Function
    end if

    Dim oFSO
    Set oFSO = CreateObject("Scripting.FileSystemObject")

    sPrompt = vbCRLF & _
        "A filename was received that doesn't appear to be an Excel Document." & vbCRLF & _
        "Do you want to skip this and all other unrecognized files?  (Will only prompt this once)" & vbCRLF & _
        "" & vbCRLF & _
        "Yes    - Will skip all further files that don't have a .xl* extension" & vbCRLF & _
        "No     - Will pass the file to excel regardless of extension" & vbCRLF & _
        "Cancel - Abort any further conversions and exit this script" & vbCRLF & _
        "" & vbCRLF & _
        "The unrecognized file was:" & vbCRLF & _
        sFilename & vbCRLF & _
        "" & vbCRLF & _
        "The path returned by the system was:" & vbCRLF & _
        oFSO.GetAbsolutePathName(sFilename) & vbCRLF

    sTitle = "Unrecognized File Type Encountered"

    sResponse =  MsgBox (sPrompt,vbYesNoCancel,sTitle)
    Select Case sResponse
    Case vbYes
        gSkip = True
    Case vbNo
        gSkip = False
    Case vbCancel
        oExcel.Quit
        WScript.Quit(10)    '*  10 Is the error code I use to indicate there was a user abort (1 because wasn't successful, + 0 because the user chose to exit)
    End Select

    PromptForSkip = gSkip
    Exit Function
End Function